<template>
    <v-container>
        <v-row>
            <v-col>
                <p class="display-1">Create new Question with Slider</p>
                <p class="font-italic font-weight-light">Okay, now let's get started! Write down your question and as
                    many answers as you like. But remember - at least one answer should be marked as correct.</p>
                <p class="font-italic font-weight-light">Oh, and by the way: Your questions title will be visible in the
                    quiz's overview! So refrain from giving away too much information there!</p>
            </v-col>
        </v-row>

        <v-row>
            <v-col>
                <question-form v-model="formData"
                               @validation="onQuestionValidation"
                               :disable-fields="requestPending"/>
            </v-col>
        </v-row>
        <!-- <v-row>
            <v-col>
                <VueSlideBar v-model="slideValue" :min="0" :max="100" /><br>
            </v-col>
        </v-row> -->
        <v-row>
            <p>Min value: </p> <vs-input v-model="minValue"/>
        </v-row>
        <v-row>
            <p>Max value: </p> <vs-input v-model="maxValue"/>
        </v-row>
        <v-row>
            <v-col>
                <v-btn block
                       @click="cancel">
                    <v-icon left>mdi-cancel</v-icon>
                    Cancel
                </v-btn>
            </v-col>
            <v-col>
                <v-btn block
                       @click="saveQuestion"
                       :disabled="requestPending || !validQuestion">
                    <v-icon left>save</v-icon>
                    Save Question
                </v-btn>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
    import QuestionForm from "./QuestionForm";
    import VueSlideBar from "vue-slide-bar";
    import Vue from 'vue';
    import Vuesax from 'vuesax';

    Vue.use(Vuesax);

    export default {
        name: "SliderQuestion",
        components: {QuestionForm, VueSlideBar},
        props: {
            quizId: Number
        },
        data: () => ({
            formData: {},
            requestPending: false,
            validQuestion: false,
            minValue: 0,
            maxValue: 100,
            slideValue: 0,
        }),
        methods: {
            cancel() {
                this.$router.go(-1);
            },
            async saveQuestion() {
                this.requestPending = true;
                this.formData.quiz_id = this.quizId;    // Add quiz id to question!
                QuestionRepository.createQuestion(this.formData)
                    .then(response => {
                        if (response.status === 200) {
                            return response.data.id;
                        }
                    })
                    .then(questionId => {
                        Promise.all(this.answers.map(answer => {
                            answer.question_id = questionId;
                            return AnswerRepository.createAnswer(answer);
                        }));
                    })
                    .then(() => {
                        this.$router.push(`/quizzes/${this.quizId}`)
                    })
                    .catch(() => {
                        this.showSnackbar("Could not persist question!");
                    })
                    .finally(() => {
                        this.requestPending = false;
                    });
            },
            onQuestionValidation(validity) {
                this.validQuestion = validity;
            },
        }
    }
</script>

<style scoped>

</style>
