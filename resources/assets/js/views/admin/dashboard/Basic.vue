<template>
  <div v-if="Read == 1" id="dashboardPage" class="main-content">
    
 <div class="row">

      <div class="col-md-12 col-lg-6 col-xl-4">
        <a class="dashbox boxClr npPointerClass" href="#">
          <i class="icon-fa icon-fa-download text-primary"/>
          <span class="title">
            <template>
              <animated-number
                :value="this.TotalDownloads"
                :round= "1"
                :duration="2000"
              />
            </template>
          </span>
          <span class="desc txtClr">Total Downloads</span>
        </a>
      </div>

      <div class="col-md-12 col-lg-6 col-xl-4">
        <a class="dashbox boxClr npPointerClass" href="#">
          <i class="icon-fa icon-fa-users text-primary"/>
          <span class="title"><template>
              <animated-number
                :value="this.MonthlyActiveUsers"
                :round= "1"
                :duration="2000"
              />
            </template></span>

          <span class="desc txtClr">Monthly Active Users</span>
        </a>
      </div>

      <div class="col-md-12 col-lg-6 col-xl-4">
        <a class="dashbox boxClr npPointerClass" href="#">
          <i class="icon-fa icon-fa-percent text-primary"/>
          <span class="title"><template>
              <animated-number
                :value="this.RetentionRate"
                :round= "1"
                :duration="2000"
              />%
            </template></span>

          <span class="desc txtClr">Retention Rate</span>
        </a>
      </div>

    </div>



    <div class="row">
      <div class="col-md-12 col-lg-6 col-xl-4">
        <a class="dashbox boxClr" href="users">
          <i class="icon-fa icon-fa-user text-primary"/>
          <span class="title">
            <template>
              <animated-number
                :value="this.UserCount"
                :round= "1"
                :duration="2000"
              />
            </template>
          </span>
          <span class="desc txtClr">Registered Users</span>
        </a>
      </div>

      <div class="col-md-12 col-lg-6 col-xl-4">
        <a class="dashbox boxClr" href="Providers">
          <i class="icon-fa icon-fa-globe text-primary"/>
          <span class="title">{{ providers }}</span>

          <span class="desc txtClr">Service Providers</span>
        </a>
      </div>

      <div class="col-md-12 col-lg-6 col-xl-4">
        <a class="dashbox boxClr" href="employees">
          <i class="icon-fa icon-fa-briefcase text-primary"/>
          <span class="title">{{ panelUsers }}</span>

          <span class="desc txtClr">mediQ Employees</span>
        </a>
      </div>

    </div>

    <div class="row">
      

      <div class="col-md-12 col-lg-6 col-xl-4">
        <a class="dashbox boxClr" href="equipments">
          <i class="icon-fa icon-fa-stethoscope text-primary"/>
          <span class="title">{{ equipment }}</span>

          <span class="desc txtClr">Equipments</span>
        </a>
      </div>

      <div class="col-md-12 col-lg-6 col-xl-4">
        <a class="dashbox boxClr" href="Tests">
          <i class="icon-fa icon-fa-wheelchair text-primary"/>
          <span class="title">{{ test }}</span>

          <span class="desc txtClr">Lab Tests</span>
        </a>
      </div>

    </div>

    <div class="row">
      <div class="col-md-12 col-lg-6 col-xl-4">
        <a class="dashbox boxClr" href="ProductOrderReport">
          <i class="icon-fa icon-fa-cubes text-primary"/>
          <span class="title">
            <template>
              <animated-number
                :value="this.pendingOrder"
                :round= "1"
                :duration="2000"
              />
            </template>
          </span>
          <span class="desc txtClr">Pending Orders</span>
        </a>
      </div>

      <div class="col-md-12 col-lg-6 col-xl-4">
        <a class="dashbox boxClr" href="ProductOrderReport">
          <i class="icon-fa icon-fa-close text-primary"/>
          <span class="title">
            <template>
              <animated-number
                :value="this.cancelOrder"
                :round= "1"
                :duration="2000"
              />
            </template>
          </span>

          <span class="desc txtClr">Cancelled Orders</span>
        </a>
      </div>

      <div class="col-md-12 col-lg-6 col-xl-4">
        <a class="dashbox boxClr" href="ProductOrderReport">
          <i class="icon-fa icon-fa-check text-primary"/>
          <span class="title">
            <template>
              <animated-number
                :value="this.completeOrder"
                :round= "1"
                :duration="2000"
              />
            </template>
          </span>

          <span class="desc txtClr">Completed Orders</span>
        </a>
      </div>

    </div>

    <div class="row">
      <div class="col-lg-12 col-xl-6 mt-2">
        <div class="card">
          <div class="card-header cardClr">
            <h6>
              <i class="icon-fa icon-fa-line-chart text-warning"/> New User's Ratio
            </h6>
          </div>
          <div class="card-body">
            <line-graph
              :labels="['Mon','Tue','Wed','Thu', 'Fri', 'Sat', 'Sun']"
              :values="usersGraphV"
            />
          </div>
        </div>
      </div>
      <div class="col-lg-12 col-xl-6 mt-2">
        <div class="card">
          <div class="card-header cardClr">
            <h6>
              <i class="icon-fa icon-fa-line-chart text-warning"/> New Orders Ratio
            </h6>
          </div>

          <div class="card-body">
            <line-graph
              :labels="['Mon','Tue','Wed','Thu', 'Fri', 'Sat', 'Sun']"
              :values="ordersInWeek"
            />
          </div>
        </div>
      </div>

    </div>
    <div class="row">
      <div class="col-lg-6 col-xl-6 mt-2">
        <div class="card">
          <div class="card-header cardClr">
            <h6>
              <i class="icon-fa icon-fa-users text-warning"/> Recent Users
            </h6>
          </div>
          <div class="card-body">
            <table-component
              :data="getRecentUsers"
              sort-by="row.id"
              sort-order="desc"
              table-class="table"
              class="max-hight"
            >

              <table-column
                :sortable="false"
                :filterable="false"
                label="User Name"
              >
                <template slot-scope="row">
                  <div>
                    <router-link :to="{ name: 'viewprofile', params: { userId: row.id }}" class="user-color">
                      {{ row.full_name }}
                    </router-link>
                  </div>
                </template>
              </table-column>

              <table-column show="phone" label="Phone"/>
              <table-column show="created_at" label="Created At"/>

              <table-column :sortable="false" :filterable="false" label>
                <template slot-scope="">
                  <div class="table__actions">
                    <router-link to="/users">
                      <a v-b-popover.hover="'View ALL Users'" class="btn btn-default btn-sm">
                        <i class="icon-fa icon-fa-users"/>
                      </a>
                    </router-link>

                  </div>
                </template>
              </table-column>
            </table-component>
          </div>
        </div>
      </div>
      <div class="col-lg-6 col-xl-6 mt-2">
        <div class="card">
          <div class="card-header cardClr">
            <h6>
              <i class="icon-fa icon-fa-users text-warning"/> Recent Employees
            </h6>
          </div>
          <div class="card-body">
            <table-component
              :data="getRecentEmployees"
              sort-by="row.id"
              sort-order="desc"
              table-class="table"
              class="max-hight"
            >

              <table-column
                :sortable="false"
                :filterable="false"
                label="User Name"
              >
                <template slot-scope="row">
                  <div>
                    <router-link :to="{ name: 'viewprofile', params: { userId: row.id }}" class="user-color">
                      {{ row.full_name }}
                    </router-link>
                  </div>
                </template>
              </table-column>

              <table-column show="phone" label="Phone"/>
              <table-column show="created_at" label="Created At"/>

              <table-column :sortable="false" :filterable="false" label>
                <template slot-scope="">
                  <div class="table__actions">
                    <router-link to="/users">
                      <a v-b-popover.hover="'View ALL Users'" class="btn btn-default btn-sm">
                        <i class="icon-fa icon-fa-users"/>
                      </a>
                    </router-link>

                  </div>
                </template>
              </table-column>
            </table-component>
          </div>
        </div>

      </div>
    </div>

  </div>
  <div v-else class="alert alert-info" role="alert">
    Sorry! you dont have permission
  </div>
</template>

<script type="text/babel">
import Vue from 'vue'
import Ls from '../../../services/ls'
import BootstrapVue from 'bootstrap-vue'
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'
import LineGraph from '../../../components/chartjs/LineChart.vue'
import BarGraph from '../../../components/chartjs/BarChart.vue'
import PieGraph from '../../../components/chartjs/PieChart.vue'
import { TableComponent, TableColumn } from 'vue-table-component'
import AnimatedNumber from 'animated-number-vue'

Vue.use(BootstrapVue)
export default {
  components: {
    LineGraph,
    BarGraph,
    PieGraph,
    TableComponent,
    TableColumn,
    AnimatedNumber
  },
  data () {
    return {
      Read: '',
      Write: '',
      Delete: '',
      value: this.UserCount,
      medicines: '',
      pendingOrder: 0,
      cancelOrder: 0,
      completeOrder: 0,
      equipment: '',
      test: '',
      basicCount: 0,
      panelUsers: '',
      providers: 0,
      today: 0,
      UserCount: 0,
      TotalDownloads:0,
      MonthlyActiveUsers:0,
      RetentionRate:0,
      usersGraphV: [],
      ordersInWeek: []
    }
  },

  mounted: function () {
    this.usersGraph()
    this.providersCount()
    this.getUserCount()
    this.getTotalDownloads()
    this.getRetentionRate()
    this.getMonthlyActiveUsers()
    this.panelUsersCount()
    this.medicinesCount()
    this.equipmentCount()
    this.testCount()
    this.ordersWeek()
    this.Read = Ls.get('auth.permissionsRead')
    this.Write = Ls.get('auth.permissionsWrite')
    this.Delete = Ls.get('auth.permissionsDelete')
    this.completeOrderCount()
    this.pendingOrderCount()
    this.cancelOrderCount()
  },

  methods: {

    repeatgraph: function () {
      setInterval(() => {
        this.usersGraph()
        this.mingledUsers()
      }, 50000)
    },

    async usersGraph () {
      try {
        const response = await axios.get('/api/admin/users/graph')
        this.usersGraphV = response.data.counterperday
      } catch (error) {
        if (error) {
          window.toastr['error']('There was an error', 'Error')
        }
      }
    },

    async ordersWeek () {
      try {
        const response = await axios.get('/api/admin/orders/orderInWeek')
        this.ordersInWeek = response.data.counterperday
      } catch (error) {
        if (error) {
          window.toastr['error']('There was an error', 'Error')
        }
      }
    },

    async getTodayDate () {
      try {
        const response = await axios.get('/api/admin/files/filetoday')
        this.today = response.data
      } catch (error) {
        if (error) {
          window.toastr['error']('There was an error', 'Error')
        }
      }
    },

    async getUserCount () {
      try {
        const response = await axios.get('/api/admin/users/usercountget')
        this.UserCount = response.data
      } catch (error) {
        if (error) {
          window.toastr['error']('There was an error', 'Error')
        }
      }
    },
    
async getTotalDownloads () {
      try {
        
        const response = await axios.get(
          '/api/total_downloads'
        )
        this.TotalDownloads = response.data.ResponseBody.data
      } catch (error) {
        if (error) {
          window.toastr['error']('There was an error', 'Error')
        }
      }
    },
    async getMonthlyActiveUsers() {
      try {
        
    const response = await axios.get(
          '/api/monthly_active_users'
        )
       
        this.MonthlyActiveUsers = response.data.ResponseBody.data
        console
      } catch (error) {
        if (error) {
          window.toastr['error']('There was an error', 'Error')
        }
      }
    },
    async getRetentionRate() {
      try {
       
        const response = await axios.get(
          '/api/retention_rate'
        )
        this.RetentionRate = response.data.ResponseBody.data
      } catch (error) {
        if (error) {
          window.toastr['error']('There was an error', 'Error')
        }
      }
    },
    async providersCount () {
      try {
        const response = await axios.get(
          '/api/admin/providers/count/get'
        )
        this.providers = response.data
      } catch (error) {
        if (error) {
          window.toastr['error']('There was an error', 'Error')
        }
      }
    },

    async panelUsersCount () {
      try {
        const response = await axios.get(
          '/api/admin/users/countPanel/get'
        )
        this.panelUsers = response.data
      } catch (error) {
        if (error) {
          window.toastr['error']('There was an error', 'Error')
        }
      }
    },

    async medicinesCount () {
      try {
        const response = await axios.get(
          '/api/admin/medicines/count/get'
        )
        this.medicines = response.data
      } catch (error) {
        if (error) {
          window.toastr['error']('There was an error', 'Error')
        }
      }
    },

    async equipmentCount () {
      try {
        const response = await axios.get(
          '/api/admin/Equipments/count/get'
        )
        this.equipment = response.data
      } catch (error) {
        if (error) {
          window.toastr['error']('There was an error', 'Error')
        }
      }
    },

    async testCount () {
      try {
        const response = await axios.get(
          '/api/admin/Tests/count/get'
        )
        this.test = response.data
      } catch (error) {
        if (error) {
          window.toastr['error']('There was an error', 'Error')
        }
      }
    },

    async completeOrderCount () {
      try {
        const response = await axios.get(
          '/api/admin/orders/completeCount/get'
        )
        // console.log(response)
        this.completeOrder = response.data
      } catch (error) {
        if (error) {
          window.toastr['error']('There was an error', 'Error')
        }
      }
    },

    async pendingOrderCount () {
      try {
        const response = await axios.get(
          '/api/admin/orders/pendingCount/get'
        )
        this.pendingOrder = response.data
      } catch (error) {
        if (error) {
          window.toastr['error']('There was an error', 'Error')
        }
      }
    },

    async cancelOrderCount () {
      try {
        const response = await axios.get(
          '/api/admin/orders/cancelCount/get'
        )
        this.cancelOrder = response.data
      } catch (error) {
        if (error) {
          window.toastr['error']('There was an error', 'Error')
        }
      }
    },

    async BasicCount () {
      try {
        const response = await axios.get(
          '/api/admin/subscriptions/basicTotal/get'
        )
        this.basicCount = response.data
      } catch (error) {
        if (error) {
          window.toastr['error']('There was an error', 'Error')
        }
      }
    },
    async getRecentUsers ({ page, filter, sort }) {
      try {
        const response = await axios.get(
          '/api/admin/users/recent/get?page=${page}&filter=${filter}'
        )

        return {
          data: response.data.data,
          pagination: {
            totalPages: response.data.last_page,
            currentPage: page,
            count: response.data.count
          }
        }
      } catch (error) {
        if (error) {
          window.toastr['error']('There was an error', 'Error')
        }
      }
    },
    async getRecentEmployees ({ page, filter, sort }) {
      try {
        const response = await axios.get(
          '/api/admin/users/recentEmp/get?page=${page}&filter=${filter}'
        )

        return {
          data: response.data.data,
          pagination: {
            totalPages: response.data.last_page,
            currentPage: page,
            count: response.data.count
          }
        }
      } catch (error) {
        if (error) {
          window.toastr['error']('There was an error', 'Error')
        }
      }
    }
  }
}
</script>
<style scoped>
.npPointerClass{
  cursor:default;
}
.npPointerClass:hover{
  background-color: white;;
}
</style>
