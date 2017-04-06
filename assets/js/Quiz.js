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
            questions: [
                {
                    type: 1,
                    question: "Hvor sidder sternum?",
                    answers: [
                        { id: 1, answer: "Brystbenet" },
                        { id: 2, answer: "Hovedet" },
                        { id: 3, answer: "Knæet" }
                    ]
                },
                {
                    type: 2,
                    question: "hvordan løfter man en baby?",
                    answers: [
                        { id: 1, answer: "Rds3nIlLRdY" },
                        { id: 2, answer: "Jeiu7y-a220" },
                        { id: 3, answer: "w_q56nyIqiI" },
                        { id: 4, answer: "_RIQm3Ogkmk" }
                    ]
                }
            ],
            answers: [],
            currentQuestion: null,
            correctAnswers: [],
            finished: false,
        }

        this.handleNextQuestion = this.handleNextQuestion.bind(this)
        this.handlePreviousQuestion = this.handlePreviousQuestion.bind(this)
        this.handleFinish = this.handleFinish.bind(this)
        this.selectAnswer = this.selectAnswer.bind(this)

        this.initialize()
    }

    initialize() {
        this.state.currentQuestion = 0
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

    handleFinish() {
        /*axios.post('/api/quiz/6/finish', this.state.answers).then(response => {
            //Get response with correct answers and display them
            console.log(response);
            this.setState({ finished: true })
        })*/

        this.setState({ finished: true })
    }

    selectAnswer(answer) {
        let answers = this.state.answers
        answers[this.state.currentQuestion] = answer

        this.setState({
            answers
        })
    }

    getQuestionData(index) {
        let question = this.state.questions[index],
            userAnswer = this.state.answers.indexOf(index) ? this.state.answers[index] : false,
            correctAnswer = this.state.correctAnswers.indexOf(index) ? this.state.correctAnswers[index] : false,
            readyOnly = this.state.finished

        if (question.type == 1) {
            return (
                <MultipleChoiceQuestion selectAnswer={this.selectAnswer}
                                        currentAnswer={userAnswer}
                                        answers={question.answers}
                                        correctAnswer={correctAnswer}
                                        readOnly={readyOnly}/>
            )
        }else if (question.type == 2) {
            return (
                <VideoQuestion selectAnswer={this.selectAnswer}
                               currentAnswer={userAnswer}
                               answers={question.answers}
                               correctAnswer={correctAnswer}
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
            return (
                <div key={index} className="main-container quiz-container">
                    <div className="question">
                        <h1>{this.state.questions[index].question}</h1>
                    </div>

                    {this.getQuestionData(index)}
                </div>
            )
        })

        if (this.state.finished) {
            message = <QuizResults question={this.state.questions} answers={this.state.answers} correctAnswers={this.state.correctAnswers} />
        }


        if (this.state.currentQuestion == this.state.questions.length - 1) {
            nextButton = <div className="button primary" onClick={this.handleFinish}>Afslut</div>
        }else {
            nextButton = <div className="button primary next" onClick={this.handleNextQuestion}>Næste</div>
        }

        return(
            <div>
                {message}

                { questions }

                <div className="quiz-actions">
                    <div className="button primary previous" onClick={this.handlePreviousQuestion}>Forrige</div>

                    {nextButton}
                </div>
            </div>
        )
    }
}

ReactDOM.render(<Quiz/>, document.getElementById('quiz'));