<template>
    <div class="md:block hidden w-1/3 h-full border-l border-lighter py-2 px-6 overflow-y-scroll relative">
        <form @submit.prevent="handleSubmitSearch">
            <input class="pl-12 rounded-full w-full p-2 bg-lighter text-sm mb-4" placeholder="Search Twitter"
                   v-model="query"/>
            <i class="fas fa-search absolute left-0 top-0 mt-5 ml-12 text-sm text-light"></i>
        </form>

        <div class="w-full rounded-lg bg-lightest my-4" style="background-color: rgb(247, 249, 249);">
            <div class=" p-3">
                <p class="text-lg font-bold">Following</p>
            </div>
            <button v-for="(user, index) in following" :key="index"
                    class="w-full flex hover:bg-lighter p-3 border-t border-lighter">
                <img :src="`${ user.profile }`" class="w-12 h-12 rounded-full border border-lighter"/>
                <div class="hidden lg:block ml-4">
                    <p class="text-sm font-bold">{{ user.name }}</p>
                    <p class="text-sm">@{{ user.username }}</p>
                </div>
                <button class="ml-auto text-sm text-blue py-1 px-4 rounded-full border-2 border-blue"
                        @click.prevent="handleDeleteFollowingPeople(index)">
                    Unfollow
                </button>
            </button>
        </div>

        <div class="w-full rounded-lg bg-lightest my-4" style="background-color: rgb(247, 249, 249);">
            <div class=" p-3">
                <p class="text-lg font-bold">Who to Follow</p>
            </div>
            <button v-for="(user, index) in follow" :key="index"
                    class="w-full flex hover:bg-lighter p-3 border-t border-lighter">
                <img :src="`${ user.profile }`" class="w-12 h-12 rounded-full border border-lighter"/>
                <div class="hidden lg:block ml-4">
                    <p class="text-sm font-bold">{{ user.name }}</p>
                    <p class="text-sm">@{{ user.username }}</p>
                </div>
                <button class="ml-auto text-sm text-blue py-1 px-4 rounded-full border-2 border-blue"
                        @click.prevent="handlePostFollowing(index)">
                    Follow
                </button>
            </button>
        </div>
    </div>
</template>
<script>
export default {
    name: 'Trend',
    data() {
        return {
            trending: [
                {top: 'techies all around', title: 'Tech', bottom: 'The technology'},
                {top: 'Apps', title: 'Flutter', bottom: '100K Tweets'},
                {top: 'Animals', title: 'Shark larger than Great white', bottom: '115k tweets'},
                {top: 'The techies nation', title: '2m servers', bottom: '30k tweets'},
            ],
            follow: [],
            following: [],
            query: ''
        }
    },
    methods: {
        handleGetAllPeople() {
            axios.get(`${this.$env.BACKEND_API}/api/v1/people/following/all/list`)
                .then(res => {
                    let response = res.data;
                    response.forEach(item => {
                        let obj = {};
                        obj.id = item.id;
                        obj.name = item.name;
                        obj.username = item.username;
                        obj.profile = item.image;
                        this.follow.push(obj);
                    })
                })
                .catch(err => {
                    this.$notification.error(this, 'Error', 'Something went wrong');
                })
        },
        handlePostFollowing(key) {
            axios.post(`${this.$env.BACKEND_API}/api/v1/people/following/${this.follow[key].id}/store`)
                .then(res => {
                    if (res.status === 201) {
                        this.follow = [];
                        this.handleGetAllPeople();
                        this.following = [];
                        this.handleGetFollowingPeopleList();
                        this.$notification.notify(this, 'Success', res.data.message);
                    }
                })
                .catch(err => {
                    this.$notification.error(this, 'Error', 'Something went wrong');
                })
        },
        handleGetFollowingPeopleList() {
            axios.get(`${this.$env.BACKEND_API}/api/v1/people/following/list`)
                .then(res => {
                    let response = res.data;
                    response.forEach(item => {
                        let obj = {};
                        obj.following_id = item.id;
                        obj.id = item.following.id;
                        obj.name = item.following.name;
                        obj.username = item.following.username;
                        obj.profile = item.following.image;
                        this.following.push(obj);

                    })
                })
                .catch(err => {
                    this.$notification.error(this, 'Error', 'Something went wrong');
                })
        },
        handleDeleteFollowingPeople(key) {
            axios.delete(`${this.$env.BACKEND_API}/api/v1/people/following/${this.following[key].following_id}/delete`)
                .then(res => {
                    if (res.status === 200) {
                        this.following = [];
                        this.handleGetFollowingPeopleList();
                        this.follow = [];
                        this.handleGetAllPeople();
                        this.$notification.notify(this, 'Success', res.data.message);
                    }
                })
                .catch(err => {
                    this.$notification.error(this, 'Error', 'Something went wrong');
                })

        },
        handleSubmitSearch() {
            if (this.query !== '') {
                this.$router.push('/search?query=' + this.query);
            }
        }
    },
    mounted() {
        this.handleGetAllPeople();
        this.handleGetFollowingPeopleList();
        this.query = this.$route.query.query;
    }
}
</script>
