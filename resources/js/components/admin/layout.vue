<template>
  <div class="admin-layout">
    <nav class="sidebar">
      <ul>
        <li>
          <router-link to="/admin">
            <i class="fas fa-tachometer-alt"></i> Dashboard
          </router-link>
        </li>
        <li>
          <router-link to="/admin/admins">
            <i class="fas fa-users"></i> Admins
          </router-link>
        </li>
        <li>
          <router-link to="/admin/companies">
            <i class="fas fa-building"></i> Companies
          </router-link>
        </li>
        <li>
          <router-link to="/admin/invitations">
            <i class="fas fa-building"></i> Invitations
          </router-link>
        </li>
        <li>
          <router-link to="/admin/histories">
            <i class="fas fa-building"></i> Historique
          </router-link>
        </li>
      </ul>
    </nav>
    <main class="content">
      <router-view :key="$route.fullPath"></router-view>
    </main>
  </div>
</template>

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
