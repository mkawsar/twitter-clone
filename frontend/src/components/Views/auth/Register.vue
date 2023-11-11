<template>
    <div class="py-16">
        <div
            class="flex justify-center items-center bg-white rounded-lg shadow-lg overflow-hidden mx-auto max-w-sm lg:max-w-4xl">
            <div class="w-full p-8 lg:w-1/2">
                <h2 class="text-2xl font-semibold text-gray-700 text-center">Brand</h2>
                <p class="text-xl text-gray-600 text-center">Welcome back!</p>
                <form autocomplete="off">
                    <div class="mt-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="name">Name</label>
                        <input
                            class="bg-gray-200 text-gray-700 focus:outline-none focus:shadow-outline border border-gray-300 rounded py-2 px-4 block w-full appearance-none"
                            type="text" name="name" id="name" placeholder="Name" v-model="fields.name"
                            v-validate="fieldsValidation.name"/>
                        <span class="mt-2 text-sm text-red-600 dark:text-red-500">{{ errors.first('name') }}</span>
                    </div>
                    <div class="mt-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="username">Username</label>
                        <input
                            class="bg-gray-200 text-gray-700 focus:outline-none focus:shadow-outline border border-gray-300 rounded py-2 px-4 block w-full appearance-none"
                            type="text" name="username" id="username" placeholder="Username" v-model="fields.username"
                            v-validate="fieldsValidation.username"/>
                        <span class="mt-2 text-sm text-red-600 dark:text-red-500">{{ errors.first('username') }}</span>
                    </div>
                    <div class="mt-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="email">Email</label>
                        <input
                            class="bg-gray-200 text-gray-700 focus:outline-none focus:shadow-outline border border-gray-300 rounded py-2 px-4 block w-full appearance-none"
                            type="email" name="email" id="email" placeholder="Email" v-model="fields.email"
                            v-validate="fieldsValidation.email"/>
                        <span class="mt-2 text-sm text-red-600 dark:text-red-500">{{ errors.first('email') }}</span>
                    </div>
                    <div class="mt-4">
                        <div class="flex justify-between">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="password">Password</label>
                        </div>
                        <input
                            class="bg-gray-200 text-gray-700 focus:outline-none focus:shadow-outline border border-gray-300 rounded py-2 px-4 block w-full appearance-none"
                            type="password" id="password" placeholder="Password" name="password"
                            v-model="fields.password" v-validate="fieldsValidation.password"/>
                        <span class="mt-2 text-sm text-red-600 dark:text-red-500">{{ errors.first('password') }}</span>
                    </div>
                    <div class="mt-4">
                        <div class="flex justify-between">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="password_confirmation">Confirm
                                Password</label>
                        </div>
                        <input
                            class="bg-gray-200 text-gray-700 focus:outline-none focus:shadow-outline border border-gray-300 rounded py-2 px-4 block w-full appearance-none"
                            type="password" id="password_confirmation" placeholder="Password Confirmation"
                            name="password_confirmation" v-model="fields.password_confirmation"
                            v-validate="fieldsValidation.password_confirmation"/>
                        <span class="mt-2 text-sm text-red-600 dark:text-red-500">{{
                                errors.first('password_confirmation')
                            }}</span>
                    </div>
                    <div class="mt-8">
                        <button class="bg-gray-700 text-white font-bold py-2 px-4 w-full rounded hover:bg-gray-600"
                                @click.prevent="handleSubmitRegistrationForm">
                            Registration
                        </button>
                    </div>
                    <div class="mt-4 flex items-center justify-between">
                        <span class="border-b w-1/5 md:w-1/4"></span>
                        <router-link to="/login" class="text-xs text-gray-500 uppercase">BACK TO SIGN IN</router-link>
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
            name: {
                required: '',
            },
            email: {
                required: '',
                min: ''
            },
            username: {
                required: '',
            },
            password: {
                required: '',
                min: ''
            },
            password_confirmation: {
                required: '',
                min: ''
            }
        }
    }
};

let userObj = {
    name: '',
    username: '',
    email: '',
    password: '',
    password_confirmation: ''
};

Vue.use(VeeValidate, {
    dictionary: veeCustomMessage,
    fieldsBagName: userObj
});

export default {
    name: "Register",
    data() {
        return {
            fields: userObj,
            fieldsValidation: {
                name: {
                    required: true
                },
                email: {
                    required: true,
                    email: true
                },
                username: {
                    required: true
                },
                password: {
                    required: true,
                    min: 6
                },
                password_confirmation: {
                    required: true,
                    min: 6
                }
            },
            loading: false
        }
    },
    methods: {
        handleSubmitRegistrationForm() {
            this.loading = true;
            this.$validator.validateAll().then((result) => {
                if (result) {
                    let data = new FormData();
                    data.append('name', this.fields.name);
                    data.append('email', this.fields.email);
                    data.append('username', this.fields.username);
                    data.append('password', this.fields.password);
                    data.append('password_confirmation', this.fields.password_confirmation);

                    axios.post(this.$env.BACKEND_API + '/api/v1/auth/registration', data)
                        .then(response => {
                            this.loading = false;
                            this.$notification.notify(this, 'Success', response.data.message);
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
            this.fields.name = '';
            this.fields.username = '';
            this.fields.email = '';
            this.fields.password = '';
            this.fields.password_confirmation = '';
            this.$router.push('/login')
        }
    }
}
</script>

<style scoped>

</style>
