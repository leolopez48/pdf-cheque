<template>
  <div class="table-responsive">
    <table class="table table-striped table-hover mt-3">
      <thead>
        <tr>
          <th>#</th>
          <th>Nombre</th>
          <th>Monto</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody v-if="data">
        <tr v-if="data.length == 0">
          <td colspan="5">No se encontraron cheques por mostrar</td>
        </tr>
        <tr v-for="(value, index) in data" :key="value.id">
          <td>{{ index + 1 }}</td>
          <td>{{ value.nombre }}</td>
          <td>{{ fixNumber(value.monto) }}</td>
          <td>
            <a href="#" class="btn btn-warning" @click="edit(value.id)"
              ><i class="fa fa-edit"></i> Editar</a
            >
            <a href="#" class="btn btn-danger" @click="deleteP(value.id)"
              ><i class="fa fa-trash"></i> Eliminar</a
            >
            <a href="#" class="btn btn-info" @click="generatePdf(value.id)"
              ><i class="fa fa-file"></i> Cheque</a
            >
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
export default {
  props: {
    data: {
      type: Array,
      required: true,
      default: () => [],
    },
  },
  mounted() {
    // console.log(this.data);
  },
  methods: {
    async deleteP(id) {
      this.$emit("delete-data", id);
    },
    async edit(id) {
      this.$emit("edit-data", id);
    },
    async generatePdf(id) {
      this.$emit("pdf-data", id);
    },

    fixNumber(monto) {
      return Number.parseFloat(monto).toFixed(2);
    },
  },
};
</script>

<style>
</style>
