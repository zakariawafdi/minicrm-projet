<template>
  <div class="container">
    <div class="row justify-content-center mt-5">
      <div class="col-md-6 col-lg-5">
        <div class="card shadow-sm">
          <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Espace employée</h4>
          </div>
          <div class="card-body">
            <form @submit.prevent="loginEmployee">
              <div class="form-group">
                <label for="email">Adresse email</label>
                <input type="email" class="form-control" id="email" aria-describedby="emailHelp" v-model="login.email" placeholder="Saisissez l'email" required>
              </div>
              <div class="form-group">
                <label for="password">Mot de passe</label>
                <input type="password" class="form-control" v-model="login.password" id="password" placeholder="Mot de passe" required>
                <div class="invalid-feedback" v-if="error">{{ error }}</div>
              </div>
              <button type="submit" class="btn btn-primary btn-block mt-3">Se connecter</button>
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
      login: {
        email: '',
        password: '',
      },
      error: ''
    }
  },
  methods: {
    loginEmployee() {
      this.error = "";
      api.post('/api/auth-employee', this.login)
      .then(response => {
        if (response.data.access_token){
          localStorage.setItem('token', response.data.access_token);
          this.$router.push('/employee/dashboard');
        }
        
      })
      .catch(error => {

          if (error.response.status === 422) {
            this.error = 'Les informations d\'identification fournies sont incorrectes.';
          } else {
            console.log(error);
          }
      });
    },
  }
}
</script>

<style scoped>
.card {
  border: none;
  border-radius: 0;
}

.card-header {
  border-radius: 0;
}

.btn-primary {
  background-color: #2E59D9;
  border-color: #4E73DF;
}

.btn-primary:hover {
  background-color: #515d82;
  border-color: #515d82;
}

.btn-primary:focus, .btn-primary.focus {
  box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.5);
}

.btn-primary:active, .btn-primary.active {
  background-color: #2E59D9;
  border-color: #2E59D9;
  box-shadow: none;
}

.invalid-feedback {
  color: red;
  display: block !important;
}
</style>
