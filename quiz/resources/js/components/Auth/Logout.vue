<template>
    <v-container>
        <v-row>
            <v-col>
                <p class="display-1">Goodbye</p>
                <p class="text-italic font-weight-light">
                    Sad to see you leave! Come back soon and show of your unbelievable quizzing skills!
                </p>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
    import Axios from 'axios';
    import { TokenHandler } from './../../handlers/TokenHandler';

    export default {
        name: "Logout",
        created() {
            this.logout();
        },
        methods: {
            logout() {
                const token = this.$root.$data.user.token;
                if (token !== undefined) {
                    TokenHandler.removeToken();
                    this.$root.$data.user = {};
                }
            }
        }
    }
</script>

<style scoped>

</style>