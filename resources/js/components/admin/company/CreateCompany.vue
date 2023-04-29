<template>
  <div class="container mt-4">
    <div class="card">
      <div class="card-header">
        <h4>Nouvelle Société</h4>
      </div>
      <div class="card-body">
        <form @submit.prevent="createCompany">
          <div class="form-group">
            <label for="name">Nom</label>
            <input type="text" class="form-control" id="name" v-model="company.name" required>
          </div>
          <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" v-model="company.email">
          </div>
          <!-- <div class="form-group">
            <label for="website">Site web</label>
            <input type="text" class="form-control" id="website" v-model="company.website">
          </div> -->
          <div class="form-group">
            <label for="legal_status">Statut juridique</label>
            <select class="form-control" id="legal_status" v-model="company.legal_status" required>
            <option value="">-- Séléctionnez un statut --</option>
            <option value="SARL">SARL</option>
            <option value="SA">SA</option>
            <option value="SAS">SAS</option>
            <option value="GIE">GIE</option>
            </select>
        </div>
        <div class="form-group">
            <label for="address">Adresse</label>
            <textarea class="form-control" id="address" v-model="company.address" required></textarea>
        </div>
        <div class="form-group">
            <label for="phone">Numéro de téléphone</label>
            <input type="text" class="form-control" id="phone" v-model="company.phone_number" required>
        </div>
        <div class="form-group">
            <label for="phone">Capital sociale</label>
            <input type="number" class="form-control" id="capital" v-model="company.capital" required>
        </div>
          <button type="submit" class="btn btn-primary mt-2">Enregister</button>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
import api from '../../../http/axios.js';
export default {
  data() {
    return {
      company: {
        name: '',
        capital: '',
        address: '',
        legal_status: '',
        phone_number: '',
        email: '',
      }
    }
  },
  methods: {
  createCompany() {
    // Define company object with form data
    const company = {
      name: this.company.name,
      capital: this.company.capital,
      address: this.company.address,
      legal_status: this.company.legal_status,
      email: this.company.email,
      phone_number: this.company.phone_number,
    };
    
    // Send POST request to API endpoint
    api.post('/api/admin/companies', company)
      .then(response => {
        // Redirect to company list page on success
        this.$router.push('/admin/companies');
      })
      .catch(error => {
        // Handle error response
        console.log(error);
      });
  }
}

}
</script>
