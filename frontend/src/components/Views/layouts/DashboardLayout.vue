<template>
    <div>
        <div id="HelloWorld" class="flex container h-screen w-full">
            <aside-tab :user="user"></aside-tab>
            <div class="w-full md:w-1/2 h-full overflow-y-scroll">
                <dashboard-content></dashboard-content>
            </div>
            <trend></trend>
        </div>
    </div>
</template>

<script>
import Content from "./Content";
import AsideTab from './Aside.vue';
import Trend from "./Trend.vue";

export default {
    name: "DashboardLayout",
    components: {
        DashboardContent: Content,
        AsideTab: AsideTab,
        Trend: Trend
    },
    data() {
        return {
            user: {}
        }
    },
    methods: {
        handleGetUserObject() {
            this.user = this.$localStorage.get('user');
        }
    },
    mounted() {
        this.handleGetUserObject();
    }
}
</script>

