<template>
  <div class="admin-login">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
          <div class="card">
            <div class="card-body">
              <h2 class="card-title text-center mb-4"> Authentification Administrator</h2>
              <form @submit.prevent="loginAdmin">
                <div class="form-group">
                  <label for="email">Adresse email</label>
                  <input type="email" v-model="login.email" class="form-control" id="email" aria-describedby="emailHelp" placeholder="Enter email" required>
                  <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
                </div>
                <div class="form-group">
                  <label for="password">Mot de passe</label>
                  <input type="password" v-model="login.password" class="form-control" id="password" placeholder="Password" required>
                  <div class="invalid-feedback" v-if="error">{{ error }}</div>
                </div>
                <button type="submit" class="btn btn-primary btn-block mt-4">Se connecter</button>
              </form>
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
    loginAdmin() {
      
      this.error = '';
      api.post('/api/auth-admin', this.login)
      .then(response => {
        
        if (response.data.access_token) {
            localStorage.setItem('token', response.data.access_token);
            console.log('data', JSON.stringify(response));
            this.$router.push('/admin');
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
.admin-login {
  height: 100vh;
  display: flex;
  justify-content: center;
  align-items: center;
  background-color: #f5f5f5;
}

.card {
  border: none;
  border-radius: 4px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.card-title {
  font-size: 24px;
}

.form-group {
  margin-bottom: 1rem;
}

.form-control {
  border: none;
  border-radius: 4px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.btn-primary {
  background-color: 333;
  border-color: #333;
}

.btn-primary:hover {
  background-color: #0069d9;
  border-color: #0062cc;
}
.invalid-feedback {
  color: red;
  display: block !important;
}
</style>