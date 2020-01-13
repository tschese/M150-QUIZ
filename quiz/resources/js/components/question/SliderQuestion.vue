<template>
    <v-container>
        <v-row>
            <v-col>
                <p class="display-1">Create new Question with Slider</p>
                <p class="font-italic font-weight-light">Okay, now let's get started! Write down your question and set a minimum, maximum and correct value for your slider.
                </p>
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

        <v-row>
            <v-col>
                <p>Min value: </p> <vs-input v-model="min"/>
            </v-col>

            <v-col>
                <p>Max value: </p> <vs-input v-model="max"/>
            </v-col>

            <v-col>
                <p>Correct value: </p> <vs-input v-model="correctValue"/>
            </v-col>
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
    import AnswerRepository from '../../repositories/AnswerRepository';
    import QuestionRepository from '../../repositories/QuestionRepository';

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
            min: 0,
            max: 100,
            correctValue: 0,
        }),
        methods: {
            cancel() {
                this.$router.go(-1);
            },
            async saveQuestion() {
                this.requestPending = true;
                this.formData.quiz_id = this.quizId;    // Add quiz id to question!
                this.formData.type = 'slider';          // Add question type.
                QuestionRepository.createQuestion(this.formData)
                    .then(response => {
                        if (response.status === 200) {
                            return response.data.id;
                        }
                    })
                    .then(questionId => {
                        let answer = {};
                        answer.min = this.min;
                        answer.max = this.max;
                        answer.correctValue = this.correctValue;
                        answer.question_id = questionId;
                        return AnswerRepository.createSliderAnswer(answer);
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
