<template>
    <v-container fluid>
        <v-row>
            <v-col>
                <p class="display-1">Leaderboard</p>
                <p class="font-italic font-weight-light">
                    Here's a list of all players. Proof your knowledge by scoring in QU!ZZES.
                </p>
            </v-col>
        </v-row>

        <v-row>
            <v-col>
                <v-card tile>
                    <v-list three-line>
                        <template v-for="(user, index) in users">
                            <v-list-item :key="user.id">
                                <v-list-item-content>
                                    <v-list-item-title>Position {{calculatePlace(index)}}: {{user.name}}</v-list-item-title>
                                    <v-list-item-subtitle>Points: {{user.score}}</v-list-item-subtitle>
                                </v-list-item-content>
                            </v-list-item>
                        </template>
                    </v-list>
                </v-card>
            </v-col>
        </v-row>

        <v-row justify="center">
            <v-col class="text-center">
                <v-btn to="/quizzes">
                    <v-icon left color="green">mdi-play</v-icon>
                    Play a QU!Z yourself
                </v-btn>
            </v-col>
        </v-row>

        <v-snackbar v-model="snackbar"
                    :right="true"
                    :top="true">
            {{ snackbarText }}
        </v-snackbar>

    </v-container>
</template>

<script>
    import { RepositoryFactory } from "./../../repositories/RepositoryFactory";

    const LeaderboardRepository = RepositoryFactory.get('leaderboard');

    export default {
        name: "Leaderboard",
        data: () => ({
            users: [],
            snackbarText: '',
            snackbar: false,
            index: 0,
        }),

        created() {
            this.fetchData();
        },

        methods: {
            fetchData() {
                LeaderboardRepository.get()
                    .then(response => {
                        if (response.status === 200) {
                            let users = response.data;
                            users.sort((a,b) => (a.score > b.score) ? -1 : ((b.score > a.score) ? 1 : 0));
                            this.users = users;
                            console.log(response);
                        } else {
                            throw Error("Failed loading leaderboard.");
                        }
                    })
                    .catch(() => {
                        this.showSnackbar("Failed loading leaderboard.");
                    });

            },

            showSnackbar(text) {
                this.snackbarText = text;
                this.snackbar = true;
            },

            calculatePlace(index) {
                return index + 1;
            }
        }
    }
</script>

<style scoped>
    .v-list-item__action--stack {
        flex-direction: row;
    }
</style>