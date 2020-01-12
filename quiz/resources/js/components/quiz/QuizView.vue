<template>
    <v-container>
        <v-row v-if="loading">
            <v-col>
                <v-progress-circular indeterminate/>
            </v-col>
        </v-row>
        <v-row v-if="quiz">
            <v-col>
                <p class="display-1">{{ quiz.title }}</p>
                <p class="font-italic font-weight-light">{{ quiz.description }}</p>
            </v-col>
        </v-row>
        <v-row v-if="quiz && quiz.user_id === $root.$data.user.id">
            <v-col>
                <question-list :quiz="quiz"></question-list>
            </v-col>
        </v-row>
        <v-row v-else>
            <v-col>
                <p>This QU!Z contains <span class="font-weight-bold">{{ questions.length }} questions</span>. This
                    means, you can actually get as much as <span class="font-weight-bold">{{ questions.length * 100 }}
                        points</span>!
                </p>
                <p>Hurry up, start this QU!Z and earn your points...</p>
            </v-col>
        </v-row>
        <v-row v-if="quiz">
            <v-col v-if="quiz.user_id === $root.$data.user.id">
                <v-menu offset-y>
                    <template v-slot:activator="{ on }">
                    <v-btn
                        block
                        v-on="on"
                    >
                        <v-icon left color="green">add</v-icon>
                        New Question
                    </v-btn>
                    </template>
                    <v-list>
                    <v-list-item
                        v-for="(item) in items"
                        :key="item.name"
                        :to="`/quizzes/${quiz.id}/${item.name}`"
                    >
                    <v-list-item-title>{{ item.title }}</v-list-item-title>
                    </v-list-item>
                    </v-list>
                </v-menu>
            </v-col>
            <v-col>
                <v-btn :to="`/quizzes/${quiz.id}/play`"
                       block>
                    <v-icon left color="green">mdi-play</v-icon>
                    Play QU!Z
                </v-btn>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
    import {RepositoryFactory} from '../../repositories/RepositoryFactory';
    import QuestionList from '../question/QuestionList';

    const QuizRepository = RepositoryFactory.get('quizzes');
    const QuestionRepository = RepositoryFactory.get('questions');

    export default {
        name: "QuizView",
        components: {
            QuestionList
        },
        data: () => ({
            loading: false,
            quiz: null,
            questions: [],
            items: [
                { title: 'Multiple Choice Question' , name: 'new-question'},
                { title: 'Slider Question', name: 'slider-question'},
            ],
        }),
        created() {
            this.fetchData();
        },
        methods: {
            fetchData() {
                this.loading = true;
                QuizRepository.getQuiz(this.$route.params.quizId)
                    .then(response => {
                        this.loading = false;
                        if (response.status === 200) {
                            this.quiz = response.data;
                            return response.data;
                        }
                    })
                    .then(quiz => QuestionRepository.getForQuiz(quiz.id))
                    .then(response => {
                        if (response.status === 200) {
                            this.questions.push(...response.data);
                        }
                    })
                    .finally(() => {
                        this.loading = false;
                    });
            }
        },
    }
</script>

<style scoped>

</style>
