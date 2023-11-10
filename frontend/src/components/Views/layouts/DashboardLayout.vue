<template>
    <div>
        <dashboard-content>

        </dashboard-content>
    </div>
</template>

<script>
import Content from "./Content";
import SidebarLayout from "./SidebarLayout";
import TopLayout from "./TopLayout";
import FooterLayout from "./FooterLayout";

export default {
    name: "DashboardLayout",
    components: {
        DashboardContent: Content,
        SidebarLayout: SidebarLayout,
        TopLayout: TopLayout,
        FooterLayout: FooterLayout,
    }
}
</script>

<style>

</style>

