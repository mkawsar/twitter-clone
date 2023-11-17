<template>
    <div class="lg:w-1/5 border-r border-lighter px-2 lg:px-6 py-2 flex flex-col justify-between">
        <div>
            <button class="h-12 w-12 hover:bg-lightblue text-3xl rounded-full text-blue" style="background-color: rgb(29, 155, 240);">
                <i class="fab fa-twitter"></i>
            </button>
            <div>
                <router-link v-for="(tab,index) in tabs" :key="index" :to="tab.path" :class="`focus:outline-none hover:text-blue flex items-center py-2 px-4 hover:bg-lightblue rounded-full mr-auto mb-3 ${ id === tab.id ? 'text-blue' : ''}`">
                    <i :class="`${ tab.icon } text-2xl mr-4 text-left`"></i>
                    <p class="text-lg font-semibold text-left hidden lg:block"> {{ tab.title }} </p>
                </router-link>
            </div>
            <button
                class="text-white bg-blue rounded-full font-semibold focus:outline-none w-12 h-12 lg:h-auto lg:w-full p-3 hover:bg-darkblue" style="background-color: rgb(29, 155, 240);">
                <p class="hidden lg:block">Tweet</p>
                <i class="fas fa-plus lg:hidden"></i>
            </button>
        </div>
        <div class="lg:w-full relative">
            <button @click="dropdown = !dropdown"
                    class="flex items-center w-full hover:bg-lightblue rounded-full p-2 focus:outline-none">
                <img :src="user.profile"
                     class="w-10 h-10 rounded-full border border-lighter"/>
                <div class="hidden lg:block ml-4">
                    <p class="text-sm font-bold leading-tight"> {{ user.name }} </p>
                    <p class="text-sm leading-tight"> @{{ user.username }} </p>
                </div>
                <i class="hidden lg:block fas fa-angle-down ml-auto text-lg"></i>
            </button>
            <div v-if="dropdown === true"
                 class="absolute bottom-0 left-0 w-64 rounded-lg shadow-md border-lightest bg-white mb-16">
                <button @click="dropdown = false"
                        class="p-3 flex items-center w-full hover:bg-lightest p-2 focus:outline-none">
                    <img :src="user.profile"
                         class="w-10 h-10 rounded-full border border-lighter"/>
                    <div class="ml-4">
                        <p class="text-sm font-bold leading-tight"> {{user.name}} </p>
                        <p class="text-sm leading-tight"> @{{user.username}} </p>
                    </div>
                    <i class="fas fa-check ml-auto test-blue"></i>
                </button>
                <button @click.prevent="handleLogout"
                        class="w-full text-left hover:bg-lightest border-t border-lighter p-3 test-sm focus:outline-none">
                    Log out @{{user.username}}
                </button>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    name: 'AsideTab',
    props: ['user'],
    data() {
        return {
            tabs: [
                {icon: 'fas fa-home', title: 'Home', id: 'home', path: '/home'},
                {icon: 'fas fa-hashtag', title: 'Explore', id: 'explore', path: ''},
                {icon: 'far fa-bell', title: 'Notifications', id: 'notifications', path: ''},
                {icon: 'far fa-envelope', title: 'Messages', id: 'messages', path: ''},
                {icon: 'far fa-bookmark', title: 'Bookmarks', id: 'bookmarks', path: ''},
                {icon: 'fas fa-clipboard-list', title: 'Lists', id: 'lists', path: ''},
                {icon: 'far fa-user', title: 'Profile', id: 'profile', path: '/profile/view'},
                {icon: 'fas fa-ellipsis-h', title: 'More', id: 'more', path: ''}
            ],
            dropdown: false,
            user: {}
        }
    },
    methods: {
        handleLogout() {
            this.dropdown = !this.dropdown;
            axios.get(`${this.$env.BACKEND_API}/api/v1/auth/logout`)
                .then(res => {
                    this.$localStorage.clear();
                    this.$router.push({name: 'login'});
                })
                .catch(err => {
                    this.$notification.notifyError(this, err.response.data);
                })
        },
    },
}
</script>