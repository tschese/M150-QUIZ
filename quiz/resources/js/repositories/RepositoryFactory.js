import QuizRepository from './QuizRepository';
import QuestionRepository from "./QuestionRepository";
import AnswerRepository from "./AnswerRepository";
import LeaderboardRepository from "./LeaderboardRepository";

const repositories = {
    quizzes: QuizRepository,
    questions: QuestionRepository,
    answers: AnswerRepository,
    leaderboard: LeaderboardRepository,
    // other repositories...
};

export const RepositoryFactory = {
    get: name => {
        const repository = repositories[name];
        return repository;
    }
};