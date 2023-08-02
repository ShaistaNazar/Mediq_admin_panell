import Vue from 'vue'
import VueRouter from 'vue-router'
import AuthService from './services/auth'

/*
 |--------------------------------------------------------------------------
 | Admin Views
 |--------------------------------------------------------------------------|
 */

// Dashboard
import Basic from './views/admin/dashboard/Basic.vue'

import InDemand from './views/admin/inDemand/InDemand.vue'

// Layouts
import LayoutBasic from './views/layouts/LayoutBasic.vue'
import MyLayout from './views/layouts/MyLayout.vue'
import MyLayout_2 from './views/layouts/MyLayout_2.vue'
import LayoutLogin from './views/layouts/LayoutLogin.vue'

// cities
import Cities from './views/admin/cities/Cities.vue'
import Newcity from './views/admin/cities/Newcity.vue'
import Editcity from './views/admin/cities/Editcity.vue'

// userTestReports
import UserTestReports from './views/admin/UserTestReports/UserTestReports.vue'
// import Newcity from './views/admin/cities/Newcity.vue'
import EditUserTestReports from './views/admin/UserTestReports/EditUserTestReports.vue'

// Services
import Services from './views/admin/Services/Services.vue'
import NewServices from './views/admin/Services/NewServices.Vue'
import EditServices from './views/admin/Services/EditServices.vue'

// ServicesProviders
import Providers from './views/admin/providers/Providers.vue'
import NewProviders from './views/admin/providers/NewProviders.vue'
import EditProviders from './views/admin/providers/EditProviders.vue'

// Medicines
import Medicines from './views/admin/medicines/Medicines.vue'
import NewMedicines from './views/admin/medicines/NewMedicines.vue'
import EditMedicines from './views/admin/medicines/EditMedicines.vue'
import LabCategory from './views/admin/medicines/LabCategory.vue'
import MedCategory from './views/admin/medicines/MedCategory.vue'
import MiscellaneousMedicines from './views/admin/medicines/MiscellaneousMedicines.vue'
import EditMiscellaneousMedicines from './views/admin/medicines/EditMiscellaneousMedicines.vue'

// Users
import DeactiveUsers from './views/admin/users/DeactiveUsers.vue'
import Users from './views/admin/users/Users.vue'
import Profile from './views/admin/users/Profile.vue'
import Newuser from './views/admin/users/Newuser.vue'
import Edituser from './views/admin/users/Edituser.vue'
import UserHistory from './views/admin/users/UserHistory.vue'
import UserPrescription from './views/admin/users/UserPrescription.vue'
import Prescription from './views/admin/prescriptions/Prescription.vue'
// import Abuse from './views/admin/users/Abuse.vue'

// employees
import Employees from './views/admin/employees/Employees.vue'
import Newemployees from './views/admin/employees/Newemployees.vue'
import Editemployees from './views/admin/employees/Editemployees.vue'
// import employeesDetails from './views/admin/employees/employeesDetails.vue'
// roles permissions
import rolesList from './views/admin/rolesPermissions/roleslist.vue'
import newRoles from './views/admin/rolesPermissions/newRoles.vue'
import editRoles from './views/admin/rolesPermissions/editRoles.vue'

// CMS
import Cms from './views/admin/Cms/Cms.vue'
import EditCms from './views/admin/Cms/EditCms.vue'
import NewCms from './views/admin/Cms/NewCms.vue'
import ViewCms from './views/admin/Cms/ViewCms.vue'

// BLOGS DASHBOARD
import Blog from './views/admin/blogs/Blog.vue'
import EditBlog from './views/admin/blogs/EditBlog.vue'
import NewBlog from './views/admin/blogs/NewBlog.vue'

// Emails 
import ContactUS from './views/admin/contactUs/ContactUS.vue'

import Laboratories from './views/admin/laboratories/Laboratories.vue'
import EditLaboratories from './views/admin/laboratories/EditLaboratories.vue'
import NewLaboratories from './views/admin/laboratories/NewLaboratories.vue'
// import ViewCms from './views/admin/Cms/ViewCms.vue'

// Tests
import Tests from './views/admin/tests/Tests.vue'
import EditTests from './views/admin/tests/EditTests.vue'
import NewTests from './views/admin/tests/NewTests.vue'

// Equipments
import Equipments from './views/admin/equipments/Equipments.vue'
import EditEquipments from './views/admin/equipments/EditEquipments.vue'
import NewEquipments from './views/admin/equipments/NewEquipments.vue'
import rentalEquipments from './views/admin/equipments/rentalEquipments.vue'

// Orders
import Orders from './views/admin/Orders/Orders.vue'
import EditOrders from './views/admin/Orders/EditOrders.vue'
import NewOrders from './views/admin/Orders/NewOrders.vue'
import MakePromotion from './views/admin/Orders/MakePromotion.vue'
import HmServiceOrders from './views/admin/Orders/hmServiceOrders.vue'
import NewOrderService from './views/admin/Orders/NewOrderService.vue'

// Reports
import ProductOrderReport from './views/admin/reports/OrderReport.vue'
import ServiceOrderReport from './views/admin/reports/ServiceOrderReport.vue'
import HighestGrossingProductReport from './views/admin/reports/HighestGrossingProductReport.vue'
import rentalEquipmentsReport from './views/admin/reports/rentalEquipmentsReport.vue'

// User Complaint
import Complaint from './views/admin/complaint/complaint.vue'
import EditComplaint from './views/admin/complaint/editComplaint.vue'
import NewComplaint from './views/admin/complaint/newComplaint.vue'

// Settings
import Settings from './views/admin/Settings.vue'

// Profile
import AdminProfile from './views/admin/Profile.vue'

/*
 |--------------------------------------------------------------------------
 | Other
 |--------------------------------------------------------------------------|
 */

// Auth
import Login from './views/auth/Login.vue'
import Forgot from './views/auth/Forgot.vue'
import Reset from './views/auth/Reset.vue'
import Verify from './views/auth/Verify.vue'
import Register from './views/auth/Register.vue'

import NotFoundPage from './views/errors/404.vue'

// Home Medics Website
import LayoutWebsite from './views/layouts/LayoutWebsite.vue'
import AppHome from './views/homeMedics/home/AppHome.vue'
import AppHomeMedics from './views/homeMedics/home_Medics/AppHomeMedics.vue'
import AppMediPass from './views/homeMedics/medi-pass/AppMediPass.vue'
import AppBlog from './views/homeMedics/blog/AppBlog.vue'
import AppMedEdu from './views/homeMedics/med-edu/AppMedEdu.vue'
import AppGallery from './views/homeMedics/gallery/AppGallery.vue'
import AppAboutUs from './views/homeMedics/about_us/AppAboutUs.vue'
import ReadBlog from './views/homeMedics/blog/ReadBlog.vue'
import WebAppStore from './views/layouts/partials/WebAppStore.vue'
/*
 |--------------------------------------------------------------------------
 | Frontend Views
 |--------------------------------------------------------------------------|
 */

Vue.use(VueRouter)

const newLocal = 'editbid'
const routes = [

  /*
   |--------------------------------------------------------------------------
   | Layout Routes for DEMO
   |--------------------------------------------------------------------------|
   */

  /*
   |--------------------------------------------------------------------------
   | Frontend Routes
   |--------------------------------------------------------------------------|
   */

  {
    path: '/',
    component: LayoutBasic,
    redirect: '/dashboard'
  },

  /**
   *
   * HomeMedics Website routes
   *
   */

  {
    path: '/',
    meta: { requiresAuthlogin: false },
    component: LayoutWebsite,
    children: [
      {
        path: 'home',
        component: AppHome,
        name: 'homeMedics'
      },
      {
        path: 'mediQ-home',
        component: AppHomeMedics,
        name: 'home-services'
      },
      {
        path: 'mediQ-pay',
        component: AppMediPass,
        name: 'medi-pass'
      },
      {
        path: 'mediQ-edu',
        component: AppMedEdu,
        name: 'med-edu'
      },
      {
        path: 'blog',
        component: AppBlog,
        name: 'blog'
      },
      {
        path: 'read-blog/:blog_id',
        component: ReadBlog,
        name: 'read-blog'
      },
      {
        path: 'gallery',
        component: AppGallery,
        name: 'gallery'
      },
      {
        path: 'about-us',
        component: AppAboutUs,
        name: 'about-us'
      },
      {
        path: 'mobile-app',
        component: WebAppStore,
        name: 'mobile-app'
      }
    ]
  },

  // Custom layouts for CMS pages
  {
    path: '/',
    component: MyLayout_2, // Change the desired Layout here
    meta: { requiresAuth: false },
    children: [
      // {
      //   path: 'Cms/ViewCms',
      //   component: ViewCms
      // },
      {
        path: 'cms/ViewCms/:testSlug',
        component: ViewCms,
        name: 'viewslug',
        props: true
      }

    ]
  },

  /*
   |--------------------------------------------------------------------------
   | Admin Backend Routes
   |--------------------------------------------------------------------------|
   */
  {
    path: '/',
    component: LayoutBasic, // Change the desired Layout here
    meta: { requiresAuth: true },
    children: [
      // Dashboard
      {
        path: '/dashboard',
        component: Basic,
        name: 'dashboard'
      },
      {
        path: 'users/profile/:userId',
        component: Profile,
        name: 'viewprofile',
        props: true
      },
      {
        path: 'inDemand',
        component: InDemand
      },
      {
        path: 'users/add',
        component: Newuser
      },
      {
        path: 'roleslist',
        component: rolesList
      },
      {
        path: 'roles/add',
        component: newRoles
      },
      {
        path: 'Roles/edit/:roleId',
        component: editRoles,
        name: 'editrole',
        props: true
      },
      {
        path: 'users/edit/:userId',
        component: Edituser,
        name: 'edituser',
        props: true
      },
      {
        path: 'users/prescription/:userId',
        component: UserPrescription,
        name: 'userPrescription',
        props: true
      },
      {
        path: 'prescriptions',
        component: Prescription
      },
      {
        path: 'users/history/:userId',
        component: UserHistory,
        name: 'historyuser',
        props: true
      },
      {
        path: 'users',
        component: Users
      },
      {
        path: 'rentalEquipments',
        component: rentalEquipments
      },
      // {
      //   path: 'users/abuse',
      //   component: Abuse
      // },
      {
        path: 'deactiveusers',
        component: DeactiveUsers
      },
      {
        path: 'employees/add',
        component: Newemployees
      },
      {
        path: 'employees/edit/:employeesId',
        component: Editemployees,
        name: 'editemployees',
        props: true
      },
      {
        path: 'employees',
        component: Employees
      },
      {
        path: 'Cms',
        component: Cms
      },

      {
        path: 'Cms/add',
        component: NewCms
      },

      {
        path: 'Cms/edit/:cmsId',
        component: EditCms,
        name: 'editcms',
        props: true
      },
      // blogs
      {
        path: 'Blogs',
        component: Blog
      },
      {
        path: 'Blogs/add',
        component: NewBlog
      },

      {
        path: 'Blogs/edit/:blogId',
        component: EditBlog,
        name: 'editblog',
        props: true
      },

      // Emails

      {
        path: 'contactUs',
        component: ContactUS
      },

      // Laboratories

      {
        path: 'Laboratories',
        component: Laboratories
      },

      {
        path: 'Laboratories/add',
        component: NewLaboratories
      },

      {
        path: 'Laboratories/edit/:LaboratoriesId',
        component: EditLaboratories,
        name: 'editLaboratories',
        props: true
      },

      // tests

      {
        path: 'Tests',
        component: Tests
      },

      {
        path: 'Tests/add',
        component: NewTests
      },

      {
        path: 'Tests/edit/:TestsId',
        component: EditTests,
        name: 'editTests',
        props: true
      },
      // User Complaints

      {
        path: 'Complaint',
        component: Complaint
      },

      {
        path: 'complaint/add',
        component: NewComplaint
      },

      {
        path: 'complaint/edit/:complaintId',
        component: NewComplaint,
        name: 'EditComplaint',
        props: true
      },

      // cities
      {
        path: 'cities',
        component: Cities
      },
      {
        path: 'cities/add',
        component: Newcity
      },

      {
        path: 'cities/edit/:cityId',
        component: Editcity,
        name: 'editcity',
        props: true
      },

      // Services
      {
        path: 'Services',
        component: Services
      },
      {
        path: 'Services/add',
        component: NewServices
      },

      {
        path: 'Services/edit/:ServicesId',
        component: EditServices,
        name: 'editServices',
        props: true
      },

      // Providers
      {
        path: 'Providers',
        component: Providers
      },
      {
        path: 'Providers/add',
        component: NewProviders
      },

      {
        path: 'Providers/edit/:ProvidersId',
        component: EditProviders,
        name: 'editProviders',
        props: true
      },

      // Equipments
      {
        path: 'equipments',
        component: Equipments
      },
      {
        path: 'equipments/add',
        component: NewEquipments
      },

      {
        path: 'equipments/edit/:EquipmentsId',
        component: EditEquipments,
        name: 'editEquipments',
        props: true
      },

      // medicines
      {
        path: 'medicines',
        component: Medicines
      },
      {
        path: 'medicines/add',
        component: NewMedicines
      },

      {
        path: 'medicines/edit/:medicineId',
        component: EditMedicines,
        name: 'editMedicines',
        props: true
      },
      {
        path: 'LabCategory',
        component: LabCategory
      },

      {
        path: 'MedCategory',
        component: MedCategory
      },
      {
        path: 'MiscellaneousMedicines',
        component: MiscellaneousMedicines
      },
      {
        path: 'miscellaneousMedicines/edit/:mMedId',
        component: EditMiscellaneousMedicines,
        name: 'EditMiscellaneousMedicines',
        props: true
      },
      {
        path: 'miscellaneousMedicines/add',
        component: EditMiscellaneousMedicines,
        name: 'EditMiscellaneousMedicines',
        props: true
      },

      // Orders
      {
        path: 'Orders',
        component: Orders
      },
      {
        path: 'hmServiceOrders',
        component: HmServiceOrders
      },
      {
        path: 'MakePromotion',
        component: MakePromotion
      },
      {
        path: 'Orders/add',
        component: NewOrders
      },
      {
        path: 'Orders/add/:OrdersId/:UserId',
        component: NewOrders,
        name: 'newOrders',
        props: true
      },

      {
        path: 'NewOrderService',
        component: NewOrderService
      },

      {
        path: 'Orders/edit/:OrdersId',
        component: EditOrders,
        name: 'editOrders',
        props: true
      },
      // Reports
      {
        path: 'ProductOrderReport',
        component: ProductOrderReport
      },
      {
        path: 'ServiceOrderReport',
        component: ServiceOrderReport
      },
      {
        path: 'HighestGrossingProductReport',
        component: HighestGrossingProductReport
      },
      {
        path: 'rentalEquipmentsReport',
        component: rentalEquipmentsReport
      },
      // UserTestReports
      {
        path: 'UserTestReports',
        component: UserTestReports
      },
      {
        path: 'UserTestReports/edit/:UserTestReportsId',
        component: EditUserTestReports,
        name: 'editUserTestReports',
        props: true
      },

      // Settings
      {
        path: 'settings',
        component: Settings
      },

      // Profile
      {
        path: 'adminprofile',
        component: AdminProfile
      }

    ]
  },

  /*
   |--------------------------------------------------------------------------
   | Auth & Registration Routes
   |--------------------------------------------------------------------------|
   */

  {
    path: '/',
    meta: { requiresAuthlogin: true },
    component: LayoutLogin,
    children: [
      {
        path: 'login',
        component: Login,
        name: 'login'
      },
      {
        path: 'forgot',
        component: Forgot,
        name: 'forgot'
      },
      {
        path: 'reset',
        component: Reset,
        name: 'reset'
      },
      {
        path: 'verify',
        component: Verify,
        name: 'verify'
      },
      {
        path: 'register',
        component: Register,
        name: 'register'
      }
    ]
  },

  // Demo Pages

  //  DEFAULT ROUTE
  { path: '*', component: NotFoundPage }
]

const router = new VueRouter({
  routes,
  mode: 'history',
  linkActiveClass: 'active',

  scrollBehavior (to, from, savedPosition) {
    if (savedPosition) {
      return savedPosition
    } else {
      return { x: 0, y: 0}
    }
  }
})

router.beforeEach((to, from, next) => {
  if (to.matched.some(m => m.meta.requiresAuth)) {
    return AuthService.check().then(authenticated => {
      if (!authenticated) {
        return next({ path: '/home' })
      }

      return next()
    })
  } else if (to.matched.some(m => m.meta.requiresAuthlogin)) {
    return AuthService.check().then(authenticated => {
      if (authenticated) {
        return next({ path: '/dashboard' })
      }

      return next()
    })
  }

  return next()
})
export default router
