<template>
  <div class="histories-list">
    <h2>Historique</h2>

    <table>
      <thead>
        <tr>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="history in histories" :key="history.id">
          <td>{{ dateFormat(history.created_at) +' / '+ history.action }}</td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
// import axios from 'axios';

import api from '../../../http/axios.js';

  export default {
    data() {
      return {
        histories: []
      }
    },
    methods: {
      fetchHistories() {
        // make API call to fetch admins data
        api.get('/api/admin/histories')
          .then(response => {
            this.histories = response.data.histories
          })
          .catch(error => {
            console.log(error)
          })
      },
      dateFormat(date) {
        const newdate = new Date(date);
        return `${newdate.getDate().toString().padStart(2, '0')}-${(newdate.getMonth() + 1).toString().padStart(2, '0')}-${newdate.getFullYear()} - ${newdate.getHours().toString().padStart(2, '0')}:${newdate.getMinutes().toString().padStart(2, '0')}`;
    },

    },
    mounted() {
      this.fetchHistories()
    }
  }
</script>


<style>
.histories-list {
  max-width: 800px;
  margin: 0 auto;
}

table {
  border-collapse: collapse;
  width: 100%;
}

th, td {
  text-align: left;
  padding: 8px;
}

th {
  background-color: #333;
  color: white;
}

tr:nth-child(even) {
  background-color: #f2f2f2;
}

tr:hover {
  background-color: #ddd;
}

</style>
