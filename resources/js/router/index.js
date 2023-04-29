import { createRouter, createWebHistory } from "vue-router";
import AdminLogin from "../components/admin/AdminLogin.vue";
import EmployeeLogin from "../components/employee/EmployeeLogin.vue";
import CompleteProfile from "../components/employee/CompleteProfile.vue";
import AdminLayout from "../components/admin/layout.vue";
import EmployeeLayout from "../components/employee/layout.vue";
import EmployeeUpdateProfile from "../components/employee/UpdateProfile.vue";
import EmployeeHome from "../components/employee/Home.vue";
import Dashboard from "../components/admin/Dashboard.vue";
import Companies from "../components/admin/company/companies.vue";
import CreateCompany from "../components/admin/company/CreateCompany.vue";
import UpdateCompany from "../components/admin/company/UpdateCompany.vue";
import Invitations from "../components/admin/invitation/Invitations.vue";
import AddAdmin from "../components/admin/AddAdmin.vue";
import UpdateAdmin from "../components/admin/UpdateAdmin.vue";
import Histories from "../components/admin/history/Histories.vue";
import CompanyEmployee from "../components/employee/company-employee/CompanyEmployee.vue";
import Admins from "../components/admin/Admins.vue";

const routes = [
    { path: "/admin/login", component: AdminLogin },
    { path: "/employee/login", component: EmployeeLogin },
    {
        path: "/employee/validate/:token",
        name: "employeeInvitation",
        component: CompleteProfile,
        props: true,
    },
    {
        path: "/admin",
        component: AdminLayout,
        beforeEnter: (to, from, next) => {
            if (localStorage.getItem("token")) {
                next();
            } else {
                next("/admin/login");
            }
        },
        children: [
            {
                path: "",
                component: Dashboard,
            },
            {
                path: "companies",
                component: Companies,
            },
            {
                path: "new",
                component: AddAdmin,
            },
            {
                path: "update/:id",
                component: UpdateAdmin,
                props: true,
            },
            {
                path: "invitations",
                component: Invitations,
                props: true,
            },
            {
                path: "company/update/:id",
                component: UpdateCompany,
                props: true,
            },
            {
                path: "company/create",
                name: "createCompany",
                component: CreateCompany,
            },
            {
                path: "admins",
                component: Admins,
            },
            {
                path: "histories",
                component: Histories,
            },
        ],
    },
    {
        path: "/employee",
        component: EmployeeLayout,
        beforeEnter: (to, from, next) => {
            if (localStorage.getItem("token")) {
                next();
            } else {
                next("/employee/login");
            }
        },
        children: [
            {
                path: "",
                component: EmployeeHome,
            },
            {
                path: "update",
                component: EmployeeUpdateProfile,
            },
            {
                path: "company",
                component: CompanyEmployee,
            },
        ],
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
