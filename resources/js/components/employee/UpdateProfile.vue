<template>
  <div class="container">
    <div class="row">
      <div class="col-md-6 offset-md-3">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Modifier Profil</h5>
            <form @submit.prevent="submitForm">
              <div class="form-group">
                <label for="name">Email: </label>
                <input type="text" class="form-control" id="name" v-model="form.email" readonly>
              </div>
              <div class="form-group">
                <label for="name">Nom: </label>
                <input type="text" class="form-control" id="name" v-model="form.name">
                <span v-if="errors.name" class="error">{{ errors.name }}</span>
              </div>
              <div class="form-group">
                <label for="address">Adresse: </label>
                <input type="text" class="form-control" id="address" v-model="form.address">
                <span v-if="errors.address" class="error">{{ errors.address }}</span>
              </div>
              <div class="form-group">
                <label for="phone_number">Numéro de téléphone:</label>
                <input type="text" class="form-control" id="phone_number" v-model="form.phone_number">
                <span v-if="errors.phone_number" class="error">{{ errors.phone_number }}</span>
              </div>
              <div class="form-group">
                <label for="date_of_birth">Date de naissance:</label>
                <input type="date" class="form-control" id="date_of_birth" v-model="form.date_of_birth">
                <span v-if="errors.date_of_birth" class="error">{{ errors.date_of_birth }}</span>
              </div>
              <div class="form-group">
                <label for="password">Mot de passe:</label>
                <input type="password" class="form-control" id="password" v-model="form.password">
                <span v-if="errors.password" class="error">{{ errors.password }}</span>
              </div>
              <div class="form-group">
                <label for="password">Comfirmer mot de passe:</label>
                <input type="password" class="form-control" id="cpassword" v-model="cpassword">
                <span v-if="errors.cpassword" class="error">{{ errors.cpassword }}</span>
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
// import VueToast from 'vue-toast-notification';
// import 'vue-toast-notification/dist/theme-sugar.css';

export default {
  data() {
    return {
      form: {
        name: '',
        address: '',
        phone_number: '',
        date_of_birth: '',
        password: '',
        email: ''
      },
      cpassword: '',
      errors: {}
    };
  },
  methods: {
    
    submitForm() {
        this.errors = {};
        if (this.form.password !== this.cpassword) {
            this.errors.cpassword = 'Les mots de passe ne correspondent pas';
            return;
        }
        if (this.form.password && this.form.password.length < 8) {
            this.errors.password = 'Le champ du mot de passe doit comporter au moins 8 caractères';
            return;
        }
        api.put('/api/employee/', this.form)
            .then(response => {
            // Handle successful response
            this.$toast.open({
              message: 'Operation successful!',
              type: 'success'
            });
            })
            .catch(error => {
            if (error.response && error.response.status === 422) {
                this.errors = error.response.data.errors;
            } else {
                console.log(error);
            }
            });
    },
    getEmployee() {
      // Submit form logic
      api.get('/api/employee/')
        .then(response => {
          // Handle successful response
           if (response.data.employee){
              this.form.name = response.data.employee.name;
              this.form.address = response.data.employee.address;
              this.form.phone_number = response.data.employee.phone_number;
              this.form.date_of_birth = response.data.employee.date_of_birth;
              this.form.email = response.data.employee.email;
           }
        })
        .catch(error => {
            console.log(error);
        });
    },

    
  },
   mounted() {
    this.getEmployee();
  }
};
</script>

<style>
.error {
  color: red;
}
</style>