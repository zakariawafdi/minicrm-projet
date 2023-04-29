<template>
  <div class="admin-layout">
    <nav class="sidebar">
      <ul>
        <li>
          <router-link to="/admin">
             Dashboard
          </router-link>
        </li>
        <li>
          <router-link to="/admin/admins">
             Admins
          </router-link>
        </li>
        <li>
          <router-link to="/admin/companies">
             Companies
          </router-link>
        </li>
        <li>
          <router-link to="/admin/invitations">
             Invitations
          </router-link>
        </li>
        <li>
          <router-link to="/admin/histories">
             Historique
          </router-link>
        </li>
        <li>
          <a @click="logout()">
             Se deconnecter
          </a>
        </li>
      </ul>
    </nav>
    <main class="content">
      <router-view :key="$route.fullPath"></router-view>
    </main>
  </div>
</template>

<script>
export default {
  name: 'home employee area',
  methods: {
   logout() {
    localStorage.removeItem('token');
    this.$router.push('/admin/login')
   }

  }
}
</script>

<style>
.admin-layout {
  display: flex;
  height: 100vh;
}

.sidebar {
  background-color: #333 !important;
  color: #fff;
  width: 200px;
  padding: 20px;
}

.sidebar ul {
  list-style: none;
  margin: 0;
  padding: 0;
}

.sidebar li {
  margin-bottom: 10px;
}

.sidebar a {
  color: #fff;
  text-decoration: none;
}

.content {
  flex: 1;
  padding: 20px;
}

.content h1 {
  margin-bottom: 20px;
}
</style>
