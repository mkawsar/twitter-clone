<template>
    <div class="relative flex w-full pt-6 bg-white border border-gray-200 justify-center rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
        <form class="w-full max-w-lg" enctype="multipart/form-data">
            <div class="flex flex-wrap -mx-3 mb-6">
                <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                           for="name">
                        Name
                    </label>
                    <input
                        class="appearance-none block w-full bg-gray-200 text-gray-700 border rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
                        id="name" name="name" type="text" placeholder="Name" v-model="fields.name" v-validate="fieldsValidation.name">
                    <p class="text-red-500 text-xs italic">{{ errors.first('name') }}</p>
                </div>
                <div class="w-full md:w-1/2 px-3">
                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                           for="username">
                        UserName
                    </label>
                    <input
                        class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                        id="username" name="username" type="text" placeholder="Username" disabled v-model="fields.username">
                </div>
            </div>
            <div class="flex flex-wrap -mx-3 mb-6">
                <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                           for="email">
                        Email
                    </label>
                    <input
                        class="appearance-none block w-full bg-gray-200 text-gray-700 border rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
                        id="email" name="email" type="text" placeholder="Email" disabled v-model="fields.email">
                </div>
                <div class="w-full md:w-1/2 px-3">
                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                           for="image">
                        Profile Image
                    </label>
                    <input
                        class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                        id="image" type="file" placeholder="File" name="image" v-validate="fieldsValidation.image" @change.prevent="handleOnChangeImageUpload">
                    <p class="text-red-500 text-xs italic">{{ errors.first('image') }}</p>
                </div>
            </div>
            <button type="button" v-if="loading === false" @click.prevent="handleSubmitProfileEditForm" class="py-2.5 px-5 me-2 mb-2 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-full border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                Update
            </button>
            <button type="button" v-else class="py-2.5 px-5 me-2 mb-2 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-full border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                Processing <i class="fa fa-spinner fa-spin"></i>
            </button>
        </form>
    </div>
</template>

<script>
import Vue from 'vue'
import * as VeeValidate from 'vee-validate';

import EventBus from "../../services/EventBus";

let veeCustomMessage = {
    en: {
        custom: {
            name: {
                required: '',
            },
            image: {
                required: ''
            }
        }
    }
};

let userObj = {
    name: '',
    image: '',
    username: '',
    email: ''
};

Vue.use(VeeValidate, {
    dictionary: veeCustomMessage,
    fieldsBagName: userObj
});
export default {
    name: 'ProfileEdit',
    data() {
        return {
            fields: userObj,
            fieldsValidation: {
                name: {
                    required: true
                },
                image: {
                    required: true
                }
            },
            loading: false,
            image: ''
        }
    },
    methods: {
        handleGetUserInfo() {
            axios.get(`${this.$env.BACKEND_API}/api/v1/auth/me`)
                .then(res => {
                    let response = res.data.data;
                    this.fields.name = response.name;
                    this.fields.username = response.username;
                    this.fields.email = response.email;
                })
                .catch(err => {
                    this.$notification.error(this, 'Error', 'Something went wrong!')
                })
        },
        handleOnChangeImageUpload(e) {
            this.image = e.target.files[0];
        },
        handleSubmitProfileEditForm() {
            this.$validator.validateAll().then((result) => {
                if (result) {
                    this.loading = true;
                    let form = new FormData();
                    form.append('name', this.fields.name);
                    form.append('image', this.image);
                    form.append('_method', 'put');
                    axios.post(`${this.$env.BACKEND_API}/api/v1/auth/profile/edit`, form)
                        .then(res => {
                            this.loading = false;
                            let userObj = {};
                            window.localStorage.removeItem('user');
                            userObj.name = res.data.user.name;
                            userObj.username = res.data.user.username;
                            userObj.profile = res.data.user.image;
                            this.$localStorage.set('user', JSON.stringify(userObj));
                            EventBus.$emit('UPDATE_AUTH_USER_PROFILE');
                            this.$notification.notify(this, 'Success', res.data.message);
                        })
                        .catch(err => {
                            this.loading = false;
                            this.$notification.notifyError(this, err.response.data);
                        })
                }
            });
        }
    },
    mounted() {
        this.handleGetUserInfo();
    }
}
</script>
