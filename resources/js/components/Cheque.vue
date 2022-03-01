<template>
  <div>
    <div class="container">
      <template v-if="!loading">
        <div class="row">
          <h1>Cheques</h1>
          <!-- Form -->
          <div class="col-md-4 d-none">
            <input class="form-control" type="text" v-model="cheque.id" />
          </div>
          <div class="col-md-4 pt-3">
            <label>Nombre</label>
            <input class="form-control" type="text" v-model="cheque.nombre" />
          </div>
          <div class="col-md-4 pt-3">
            <label>Monto (US$)</label>
            <input
              class="form-control"
              type="number"
              step="0.01"
              v-model="cheque.monto"
              disabled
            />
          </div>
          <!-- <hr /> -->
          <div class="col-md-6 pt-3">
            <a href="#" class="btn btn-info" @click="agregarConcepto()">
              <i class="fa fa-plus"></i> Agregar concepto</a
            >
          </div>
          <div class="row" v-for="(concepto, index) in conceptos" :key="index">
            <div class="col-md-4 pt-3">
              <label>Código</label>
              <input
                class="form-control"
                type="text"
                v-model="concepto.codigo"
              />
            </div>
            <div class="col-md-3 pt-3">
              <label>Concepto</label>
              <input
                class="form-control"
                type="text"
                v-model="concepto.concepto"
              />
            </div>
            <div class="col-md-3 pt-3">
              <label>Monto</label>
              <input
                @change="calcularMontoTotal"
                class="form-control"
                type="number"
                step="0.01"
                v-model="concepto.monto"
              />
            </div>
            <div class="col-md-2 pt-3">
              <a
                href="#"
                class="btn btn-danger mt-4"
                @click="borrarConcepto(index)"
              >
                <i class="fa fa-trash"></i> Eliminar</a
              >
            </div>
          </div>
          <div class="row">
            <div class="col-md-6 pt-3">
              <a href="#" class="btn btn-success" @click="save()">
                <i class="fa fa-save"></i> {{ textButton }}</a
              >
            </div>
          </div>

          <!-- Table -->
          <table-data
            :data="cheques"
            @delete-data="deleteP($event)"
            @edit-data="edit($event)"
            @pdf-data="generatePDF($event)"
          />
        </div>
      </template>
      <template v-else>
        <loader />
      </template>
    </div>
  </div>
</template>

<script>
import ui from "../libs/ui";

export default {
  data: () => {
    return {
      cheque: {
        nombre: "",
        monto: 0.0,
      },
      cheques: [],
      textButton: "Guardar",
      loading: false,
      conceptoDefecto: {
        codigo: "",
        concepto: "",
        monto: 0.0,
      },
      conceptos: [],
      disableButton: true,
    };
  },

  mounted() {
    this.initialize();
  },

  methods: {
    async initialize() {
      this.loading = true;
      const res = await axios.get("api/cheque");
      this.cheques = res.data.cheques;
      this.loading = false;
    },

    async save() {
      if (!this.verificarDatos()) {
        ui.alert(
          "Debes completar todos los campos y verificar que exista al menos 1 concepto.",
          "error",
          2000
        );
        return;
      }

      let res;

      switch (this.textButton) {
        case "Guardar":
          res = await axios.post("api/cheque", {
            cheque: this.cheque,
            conceptos: this.conceptos,
          });
          this.cheques = res.data.cheques;
          ui.alert("Registro creado correctamente.");
          this.initialize();
          this.cleanInputs();
          break;
        case "Modificar":
          res = await axios.put(`api/cheque/${this.cheque.id}`, {
            cheque: this.cheque,
            conceptos: this.conceptos,
          });
          ui.alert("Registro modificado correctamente.");
          this.initialize();
          this.cleanInputs();
          break;
      }
    },

    async edit(id) {
      this.cheque = this.cheques.find((cheque) => cheque.id == id);
      this.textButton = "Modificar";
      const res = await axios.post("api/conceptos/cheque", {
        id: id,
      });
      this.conceptos = res.data.conceptos;
    },

    async deleteP(id) {
      this.calcularMontoTotal();
      const res = await axios.delete(`api/cheque/${id}`);
      ui.alert("Registro eliminado correctamente.");
      this.cleanInputs();
      this.initialize();
    },

    cleanInputs() {
      this.cheque = {
        monto: 0.0,
      };
      this.conceptos = [];
      this.textButton = "Guardar";
    },

    generatePDF(id) {
      window.location = "/pdf/" + id;
    },

    agregarConcepto() {
      this.conceptos.push(this.conceptoDefecto);
      this.conceptoDefecto = {
        codigo: "",
        concepto: "",
        monto: 0.0,
      };
    },

    borrarConcepto(index) {
      this.conceptos.splice(index, 1);
      this.calcularMontoTotal();
    },

    calcularMontoTotal() {
      this.cheque.monto = 0;

      this.conceptos.forEach((concepto) => {
        if (!concepto.monto) {
          concepto.monto = 0;
        }

        this.cheque.monto =
          Number.parseFloat(this.cheque.monto) +
          Number.parseFloat(concepto.monto);
      });
      this.cheque.monto = Number.parseFloat(this.cheque.monto).toFixed(2);
    },

    verificarDatos() {
      let validated = true;
      if (!this.cheque.nombre || this.conceptos.length == 0) {
        validated = false;
      }

      for (let index = 0; index < this.conceptos.length; index++) {
        if (!this.conceptos[index].monto) {
          this.conceptos[index].monto = 0;
          break;
        }

        if (!this.conceptos[index].concepto || !this.conceptos[index].codigo) {
          validated = false;
          break;
        }
      }

      return validated;
    },
  },
};
</script>

<style>
</style>
