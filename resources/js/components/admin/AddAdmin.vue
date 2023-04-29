<template>
  <div class="container">
    <div class="row">
      <div class="col-md-6 offset-md-3">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Nouveau admin</h5>
            <form @submit.prevent="submitForm">
              <div class="form-group">
                <label for="name">Nom</label>
                <input type="text" class="form-control" id="name" v-model="form.name" :class="{ 'is-invalid': errors.name }" required>
                <div class="invalid-feedback" v-if="errors.name">{{ errors.name }}</div>
              </div>
              <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" v-model="form.email" :class="{ 'is-invalid': errors.email }" required>
                <div class="invalid-feedback" v-if="errors.email">{{ errors.email }}</div>
              </div>
              <div class="form-group">
                <label for="password">Mot de passe</label>
                <input type="password" class="form-control" id="password" v-model="form.password" :class="{ 'is-invalid': errors.password }" required>
                <div class="invalid-feedback" v-if="errors.password">{{ errors.password }}</div>
              </div>
              <button type="submit" class="btn btn-primary mt-2">Enregister</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import api from '../../http/axios.js';

export default {
  data() {
    return {
      form: {
        name: '',
        email: '',
        password: ''
      },
      errors: {}
    };
  },
  methods: {
    submitForm() {
      this.errors = {};
      if (this.form.password.length < 8) {
        this.errors.password = 'Le champ du mot de passe doit comporter au moins 8 caractères';
        return;
      }
      api.post('/api/admins', this.form)
        .then(response => {
          // Handle successful response
          this.$router.push('/admin/admins');
        })
        .catch(error => {
          if (error.response.status === 422) {
            this.errors = error.response.data.errors;
          } else {
            console.log(error);
          }
        });
    }
  }
};
</script>

<style>
.is-invalid {
  border-color: red;
}
.invalid-feedback {
  color: red;
}
.btn {
    background: #333;
}
</style>