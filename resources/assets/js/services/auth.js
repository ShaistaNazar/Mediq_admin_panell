import Ls from './ls'

export default {
    async login(loginData) {
        try {
            let response = await axios.post('/api/auth/login', loginData)

            Ls.set('auth.token', response.data.token)
            Ls.set('auth.avatar', response.data.currentUser.avatar)
            Ls.set('auth.admin_id', response.data.currentUser.id)
            Ls.set('auth.currentUser', response.data.currentUser.id)

            Ls.set('auth.permissionsRead', response.data.permissions.Read)
            Ls.set('auth.permissionsWrite', response.data.permissions.Write)
            Ls.set('auth.permissionsDelete', response.data.permissions.Delete)

            toastr['success']('Logged In!', 'Success')

            return response.data.token

        } catch (error) {

            if (error.response) {
                if (error.response.status === 401) {
                    toastr['error']('User-Name or Password is incorrect', 'Error')
                }
            } else {
                toastr['error'](error.message, 'Error')
            }
        }
    },

    async forgot(loginData) {

        try {

            let response = await axios.post('/api/auth/forgot', loginData)

            console.log(response);

            toastr['success']('Recovery Code sent to your phone number', 'Success')

            return true;

        } catch (error) {

            if (error.response.status === 401) {
                toastr['error']('Invalid Phone Number', 'Error')
            } else {
                // Something happened in setting up the request that triggered an Error
                toastr['error'](error.message, 'Error')

            }
        }
    },

    async verify(loginData) {
        try {
            let response = await axios.post('/api/auth/verify', loginData)
            toastr['success']('Code varified', 'Success')

            Ls.set('auth.varifyId', response.data)
            return true;
        } catch (error) {
            if (error.response.status === 401) {

                toastr['error']('Invalid Code', 'Error')
            } else {
                // Something happened in setting up the request that triggered an Error
                toastr['error'](error.message, 'Error')
            }
        }
    },

    async reset(loginData) {
        try {
            let verifyid = Ls.get('auth.varifyId');
            loginData.id = verifyid;
            let response = await axios.post('/api/auth/reset', loginData)
            toastr['success']('Password updated', 'Success')
            return true;
        } catch (error) {
            console.log(error);
            if (error.response.status === 401) {

                toastr['error']('Something Went Wrong', 'Error')
            } else {
                // Something happened in setting up the request that triggered an Error
                toastr['error'](error.message, 'Error')
            }
        }
    },

    async logout() {
        try {
            await axios.get('/api/auth/logout')

            Ls.remove('auth.token')
            toastr['success']('Logged out!', 'Success')
        } catch (error) {
            toastr['error'](error.message, 'Error')
        }
    },

    async check() {
        let response = await axios.get('/api/auth/check')

        return !!response.data.authenticated
    },
    // async LoggedInEmp () {
    //   try {
    //     let response = await axios.get('/api/admin/users/permitEmp');


    //   } catch (error) {
    //       toastr['error'](error.message, 'Error')
    //   }
    // },
}