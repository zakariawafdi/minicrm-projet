<template>
  <div class="employee-layout">
    <nav class="sidebar">
      <ul>
        <li>
          <router-link to="/employee">
            <i class="fas fa-tachometer-alt"></i> Acceuil
          </router-link>
        </li>
        <li>
          <router-link to="/employee/update">
            <i class="fas fa-users"></i> Profil
          </router-link>
        </li>
        <li>
          <router-link to="/employee/company">
            <i class="fas fa-building"></i> Société
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
.employee-layout {
  display: flex;
  height: 100vh;
}

.sidebar {
  background-color: #275ec5;
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
