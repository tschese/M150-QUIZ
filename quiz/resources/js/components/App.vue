<template>
    <v-app>

        <navigation-drawer v-model="drawer"></navigation-drawer>

        <v-app-bar app
                   color="green"
                   dark
                   clipped-left>

            <v-app-bar-nav-icon @click.stop="drawer = !drawer"></v-app-bar-nav-icon>

            <v-toolbar-title>QU!Z</v-toolbar-title>

            <v-spacer></v-spacer>

            <v-btn v-if="checkLoginStatus()"
                   icon
                   to="/login">
                <v-icon>mdi-login</v-icon>
            </v-btn>

            <div v-else>
                <span v-if="name !== null && name !== ''">Welcome, {{name}}!</span>
                <v-btn 
                   icon
                   to="/logout">
                <v-icon>mdi-logout</v-icon>
            </v-btn>
            </div>
            
        </v-app-bar>

        <v-content>
            <router-view></router-view>
        </v-content>

        <v-footer app
                  color="green">
            <span class="white--text">&copy; GIBZ 2019</span>
        </v-footer>
    </v-app>
</template>

<script>
    import NavigationDrawer from "./navigation/NavigationDrawer";

    export default {
        components: {NavigationDrawer},
        props: {
            source: String,
        },
        data: () => ({
            drawer: false,
            activeUser: false,
            name,
        }),
        created() {
            this.checkLoginStatus();
        },
        methods: {
            checkLoginStatus() {
                if (this.$root.$data.user !== undefined) {
                    if (this.$root.$data.user.token !== undefined && this.$root.$data.user.token !== null){
                        try {
                            let name = JSON.parse(JSON.stringify(this.$root.$data.user.name));
                            this.name = name;
                        }
                        catch {}
                        return false;
                    }
                    else{
                        return true;
                    }
                }
                else{
                    return true;
                }
            }
        }
    }
</script>

<style>
    a:hover {
        text-decoration: none;
    }
</style>