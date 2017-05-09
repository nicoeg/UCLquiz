import React from 'react'
import ReactDOM from 'react-dom'
import axios from 'axios'

import MultipleChoiceQuestion from './QuestionTypes/MultipleChoiceQuestion'
import VideoQuestion from './QuestionTypes/VideoQuestion'
import QuizResults from './QuizResults'

class Quiz extends React.Component {
    constructor(props) {
        super(props);

        this.state = {
            quiz: { id: 1 },
            questions: [],
            answers: [],
            currentQuestion: null,
            correctAnswers: [],
            finished: false,
            showAnswers: false
        }

        this.handleNextQuestion = this.handleNextQuestion.bind(this)
        this.handlePreviousQuestion = this.handlePreviousQuestion.bind(this)
        this.toggleAnswers = this.toggleAnswers.bind(this)
        this.handleFinish = this.handleFinish.bind(this)
        this.selectAnswer = this.selectAnswer.bind(this)

        this.initialize()
    }

    initialize() {
        axios.get(window.settings.baseUrl + 'api/quiz_rest/getSingle/' + quizId).then(response => {
            this.setState({
                quiz: response.data,
                questions: response.data.questions,
                currentQuestion: 0
            })
        })
    }

    handleNextQuestion() {
        if (this.state.questions.length > this.state.currentQuestion + 1) {
            this.setState({
                currentQuestion: this.state.currentQuestion + 1
            })
        }
    }

    handlePreviousQuestion() {
        if (this.state.currentQuestion != 0) {
            this.setState({
                currentQuestion: this.state.currentQuestion - 1
            })
        }
    }

    toggleAnswers() {
        this.setState({
            showAnswers: !this.state.showAnswers
        })
    }

    handleFinish() {
        axios.post(window.settings.baseUrl + '/api/quiz_rest/saveResult/' + this.state.quiz.id, {answers: this.state.answers}).then(response => {
            //Get response with correct answers and display them
            this.setState({
                finished: true,
                correctAnswers: response.data
            })
        })
    }

    selectAnswer(answer_id) {
        const question = this.state.questions[this.state.currentQuestion],
              answers = this.state.answers,
              data = { question_id: question.id, answer_id: answer_id },
              existing = answers.findIndex(answer => answer.question_id == question.id)

        if (existing != -1) {
            answers[existing] = data
        }else {
            answers.push(data)
        }

        this.setState({
            answers
        })
    }

    getQuestionData(index) {
        let question = this.state.questions[index],
            userAnswer = this.state.answers.find(answer => answer.question_id == question.id),
            correctAnswer = this.state.correctAnswers.find(answer => answer.question_id == question.id),
            readyOnly = this.state.finished

        if (question.type == 1) {
            return (
                <MultipleChoiceQuestion selectAnswer={this.selectAnswer}
                                        currentAnswer={userAnswer ? userAnswer : false}
                                        answers={question.answers}
                                        correctAnswer={correctAnswer ? correctAnswer : false}
                                        readOnly={readyOnly}/>
            )
        }else if (question.type == 2) {
            return (
                <VideoQuestion selectAnswer={this.selectAnswer}
                               currentAnswer={userAnswer ? userAnswer : false}
                               answers={question.answers}
                               correctAnswer={correctAnswer ? correctAnswer : false}
                               readOnly={readyOnly}/>
            )
        }
    }

    render() {
        if (this.state.currentQuestion === null && !this.state.finished) {
            return <div>Loading...</div>
        }

        let questions = this.state.finished ? Object.keys(this.state.questions) : [ this.state.currentQuestion ],
            nextButton,
            message

        questions = questions.map(index => {
            return this.state.finished && this.state.showAnswers || !this.state.finished ? (
                <div key={index} className="main-container quiz-container quiz-container--horizontal">
                    <div className="question">
                        <h1>{this.state.questions[index].question}</h1>
                    </div>

                    {this.getQuestionData(index)}
                </div>
            ) : ''
        })

        if (this.state.finished) {
            message = (
                <div>
                    <QuizResults questions={this.state.questions} answers={this.state.answers} correctAnswers={this.state.correctAnswers} />

                    <div className="quiz-actions finished">
                        <div className="button button--primary" onClick={this.toggleAnswers}>Se svar</div>

                        <div className="button button--primary next">Afslut</div>
                    </div>
                </div>
            )
        }

        if (this.state.currentQuestion == this.state.questions.length - 1) {
            nextButton = <div className="button button--primary" onClick={this.handleFinish}>Afslut</div>
        }else {
            nextButton = <div className="button button--primary next" onClick={this.handleNextQuestion}>Næste</div>
        }

        const quizActions = !this.state.finished ? (
            <div className="quiz-actions">
                <div className={'button button--primary previous ' + (this.state.currentQuestion == 0 ? 'button--disabled' : '')} onClick={this.handlePreviousQuestion}>Forrige</div>

                {nextButton}
            </div>
        ) : ''

        return(
            <div>
                {message}

                {questions}

                {quizActions}
            </div>
        )
    }
}

ReactDOM.render(<Quiz/>, document.getElementById('quiz'));
