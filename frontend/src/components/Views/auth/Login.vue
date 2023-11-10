<template>
    <div class="min-h-screen bg-no-repeat bg-cover bg-center"
         style="background-image: url(./static/images/background/login-cover.jpeg)">
        <div class="flex justify-end">
            <div class="bg-white min-h-screen w-1/2 flex justify-center items-center">
                <div>
                    <form @submit.prevent="handleSubmitLoginForm">
                        <div>
                            <span class="text-sm text-gray-900">Welcome back</span>
                            <h1 class="text-2xl font-bold">Login to your account</h1>
                        </div>
                        <div class="my-3">
                            <label class="block text-md mb-2" for="email">Email</label>
                            <input class="px-4 w-full border-2 py-2 rounded-md text-sm outline-none" type="email"
                                   id="email"
                                   v-model="user.email"
                                   v-validate="userValidation.email"
                                   name="email" placeholder="Email">
                            <p class="text-xs italic text-red-500" v-show="errors.has('email')">{{errors.first('email')}}</p>
                        </div>
                        <div class="mt-5">
                            <label class="block text-md mb-2" for="password">Password</label>
                            <input class="px-4 w-full border-2 py-2 rounded-md text-sm outline-none" type="password"
                                   id="password"
                                   v-model="user.password"
                                   v-validate="userValidation.password"
                                   name="password" placeholder="Password">
                            <p class="text-xs italic text-red-500" v-show="errors.has('password')">{{errors.first('password')}}</p>
                        </div>
                        <div class="flex justify-between">
                            <div>
                                <input class="cursor-pointer" type="radio" name="rememberme">
                                <span class="text-sm">Remember Me</span>
                            </div>
                            <span class="text-sm text-blue-700 hover:underline cursor-pointer">Forgot password?</span>
                        </div>
                        <div class="">
                            <button
                                :disabled="loading"
                                class="mt-4 mb-3 w-full bg-gray-700 hover:bg-gray-600 text-white py-2 rounded-md transition duration-100"
                                :class="loading === true ? 'cursor-not-allowed' : ''">
                                Login now <i class="fa fa-spinner fa-spin" v-if="loading"></i>
                            </button>
                        </div>
                    </form>
                    <p class="mt-8"> Dont have an account? <span class="cursor-pointer text-sm text-blue-600"> Join free today</span>
                    </p>
                </div>
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
            user: userObj,
            userValidation: {
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
            this.$router.push('/hello/world')
        }
    }
}
</script>

<style scoped>

</style>
