<template>
    <div class="container">
    <div class="row">
      <div class="col-md-6 offset-md-3">
        <div class="card mt-3">
          <div class="card-body">
            <h5 class="card-title">Completer le profil</h5>
            
            <form v-if="!isUnvalide" @submit.prevent="submitForm">
              <div class="mb-3">
                Bonjour {{form.name}}, vous avez été invité a rejoindre {{company}}
              </div>
              <div class="form-group">
                <label for="password">Mot de passe:</label>
                <input type="password" id="password" name="password" v-model="form.password" required>
                <span v-if="errors.password" class="error">{{ errors.password }}</span>
              </div>
              <div class="form-group">
                <label for="cpassword">Comfirmer mot de passe:</label>
                <input type="password" id="cpassword" name="cpassword" v-model="cpassword" required>
                <span v-if="errors.cpassword" class="error">{{ errors.cpassword }}</span>
              </div>
              <div class="form-group">
                <label for="name">Nom:</label>
                <input type="text" id="name" name="name" v-model="form.name" required>
                <span v-if="errors.name" class="error">{{ errors.name }}</span>
              </div>
              <div class="form-group">
                <label for="address">Adresse:</label>
                <input type="text" id="address" name="address" v-model="form.address" required>
                <span v-if="errors.address" class="error">{{ errors.address }}</span>
              </div>
              <div class="form-group">
                <label for="phone_number">Numéro de téléphone:</label>
                <input type="tel" id="phone_number" name="phone_number" v-model="form.phone_number" required>
                <span v-if="errors.phone_number" class="error">{{ errors.phone_number }}</span>
              </div>
              <div class="form-group">
                <label for="date_of_birth">Date de naissance:</label>
                <input type="date" id="date_of_birth" name="date_of_birth" v-model="form.date_of_birth" required>
                <span v-if="errors.date_of_birth" class="error">{{ errors.date_of_birth }}</span>
              </div>
              <button type="submit" class="btn btn-primary mt-2">Enregister</button>
            </form>

            <div v-if="isUnvalide">
               L'invitation n'est plus valide.
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import api from '../../http/axios.js';

export default {
  name: 'CompleteProfilForm',
  data() {
    return {
      form: {
        name: '',
        address: '',
        phone_number: '',
        password: '',
        cpassword: '',
        date_of_birth: '',
      },
      company: '',
      isUnvalide: false,
      cpassword: '',
      token: '',
      errors: {}
    };
  },
  methods: {
    checkInvitation() {

      api.get('/api/employee/check-invitation/'+ this.token)
        .then(response => {
          // Handle successful response
           if (response.data.employee && response.data.employee){
              this.form.name = response.data.employee;
              this.company = response.data.company;
           } else {
            this.isUnvalide = true;
           }
        })
        .catch(error => {
            this.isUnvalide = true;
        });
    },
    submitForm() {
      this.errors = {};
      if (this.form.password !== this.cpassword) {
        this.errors.cpassword = 'Les mots de passe ne correspondent pas';
        return;
      }
      if (this.form.password.length < 8) {
        this.errors.password = 'Le champ du mot de passe doit comporter au moins 8 caractères';
        return;
      }
     
      // Submit form logic
      api.put('/api/employee/validate/'+ this.token, this.form)
        .then(response => {
          // Handle successful response
           if (response.data.access_token){
              localStorage.setItem('token', response.data.access_token);
              this.$router.push('/employee/dashboard');
           }
        })
        .catch(error => {
          if (error.response.status === 422) {
            this.errors = error.response.data.errors;
          } else {
            console.log(error);
          }
        });
    },
  },
  mounted() {
    this.token = this.$route.params.token;
    this.checkInvitation();
  }
};
</script>

<style scoped>
.form-container {
  max-width: 600px;
  margin: 0 auto;
}

.form-group {
  margin-bottom: 1rem;
}

label {
  display: block;
  margin-bottom: 0.5rem;
}

input[type="text"],
input[type="password"],
input[type="tel"],
input[type="date"] {
  width: 100%;
  padding: 0.5rem;
  border: 1px solid #ccc;
  border-radius: 4px;
  font-size: 1rem;
}

button[type="submit"] {
  background-color: #007bff;
  color: #fff;
  border: none;
  border-radius: 4px;
  padding: 0.5rem 1rem;
  font-size: 1rem;
  cursor: pointer;
}
.error {
  color:red;
  padding-left: 1rem;
}
</style>