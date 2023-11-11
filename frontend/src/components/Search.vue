<template>
    <div class="w-full rounded-lg bg-lightest my-4">
        <button v-for="(user, index) in users" :key="index"
                class="w-full flex hover:bg-lighter p-3 border-t border-lighter">
            <img :src="`${ user.file_id }`" class="w-12 h-12 rounded-full border border-lighter"/>
            <div class="hidden lg:block ml-4">
                <p class="text-sm font-bold">{{ user.name }}</p>
            </div>
            <span class="ml-auto text-sm text-blue py-1 px-4 rounded-full border-2 border-blue">
                    @{{ user.username }}
            </span>
        </button>
    </div>
</template>

<script>
export default {
    name: 'Search',
    data() {
        return {
            users: []
        }
    },
    watch: {
        '$route.query.query': {
            handler: function(search) {
                let form = new FormData();
                form.append('search', search);
                axios.post(`${this.$env.BACKEND_API}/api/v1/auth/search`, form)
                    .then(res => {
                        this.users = res.data;
                    })
                    .catch(err => {
                        this.$notification.error(this, 'Error', 'Something went wrong');
                    })
            },
            deep: true,
            immediate: true
        }
    }
}
</script>
