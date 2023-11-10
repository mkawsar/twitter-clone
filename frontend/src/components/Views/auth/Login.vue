<template>
    <div class="py-16">
        <div class="flex justify-center items-center bg-white rounded-lg shadow-lg overflow-hidden mx-auto max-w-sm lg:max-w-4xl">
            <div class="w-full p-8 lg:w-1/2">
                <h2 class="text-2xl font-semibold text-gray-700 text-center">Brand</h2>
                <p class="text-xl text-gray-600 text-center">Welcome back!</p>
                <form autocomplete="off">
                    <div class="mt-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="email">Email or Username</label>
                        <input
                            class="bg-gray-200 text-gray-700 focus:outline-none focus:shadow-outline border border-gray-300 rounded py-2 px-4 block w-full appearance-none"
                            type="text" name="email" id="email" placeholder="Email or username" v-model="fields.email" v-validate="fieldsValidation.email"/>
                        <span class="mt-2 text-sm text-red-600 dark:text-red-500">{{ errors.first('email') }}</span>
                    </div>
                    <div class="mt-4">
                        <div class="flex justify-between">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="password">Password</label>
                            <a href="javascript:void(0)" class="text-xs text-gray-500">Forget Password?</a>
                        </div>
                        <input
                            class="bg-gray-200 text-gray-700 focus:outline-none focus:shadow-outline border border-gray-300 rounded py-2 px-4 block w-full appearance-none"
                            type="password" id="password" placeholder="Password" name="password" v-model="fields.password" v-validate="fieldsValidation.password"/>
                        <span class="mt-2 text-sm text-red-600 dark:text-red-500">{{ errors.first('password') }}</span>
                    </div>
                    <div class="mt-8">
                        <button class="bg-gray-700 text-white font-bold py-2 px-4 w-full rounded hover:bg-gray-600" @click.prevent="handleSubmitLoginForm">Login
                        </button>
                    </div>
                    <div class="mt-4 flex items-center justify-between">
                        <span class="border-b w-1/5 md:w-1/4"></span>
                        <a href="#" class="text-xs text-gray-500 uppercase">or sign up</a>
                        <span class="border-b w-1/5 md:w-1/4"></span>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
import Vue from 'vue'
import * as VeeValidate from 'vee-validate';

let veeCustomMessage = {
    en: {
        custom: {
            email: {
                required: '',
                email: '',
            },
            password: {
                required: '',
                min: ''
            }
        }
    }
};

let userObj = {
    email: '',
    password: ''
};

Vue.use(VeeValidate, {
    dictionary: veeCustomMessage,
    fieldsBagName: userObj
});

export default {
    name: "Login",
    data() {
        return {
            fields: userObj,
            fieldsValidation: {
                email: {
                    required: true,
                    email: true
                },
                password: {
                    required: true,
                    min: 6
                }
            },
            loading: false
        }
    },
    methods: {
        handleSubmitLoginForm() {
            this.loading = true;
            this.$validator.validateAll().then((result) => {
                if (result) {
                    let data = new FormData();
                    data.append('email', this.user.email);
                    data.append('password', this.user.password);

                    axios.post(this.$env.BACKEND_API + 'employer/login', data)
                    .then(response => {
                        this.loading = false;
                        Object.keys(response.data.response).forEach((key) => {
                            // this.$localStorage.set(key, response.data.response[key]);
                            if (key === 'user') {
                                let userRoles = [];
                                let roles = response.data.response[key].role.name;
                                userRoles.push(roles);
                                let userObj = {};
                                userObj.name = response.data.response.user.name;
                                userObj.picture = response.data.response.user.profile_picture;
                                this.$localStorage.set('user', JSON.stringify(userObj));
                                this.$localStorage.set('roles', userRoles);
                            }

                            if (key === 'token') {
                                this.$localStorage.set(key, response.data.response[key]);
                            }
                        });
                        this.handleRedirect();
                    })
                    .catch(err => {
                        this.loading = false;
                        this.$notification.notifyError(this, err.response.data);
                    })
                }
            })
        },
        handleRedirect() {
            this.$router.push('/home')
        }
    }
}
</script>

<style scoped>

</style>
