import React from 'react'
import ReactDOM from 'react-dom'

import MultipleChoiceQuestion from './QuestionTypes/MultipleChoiceQuestion'
import VideoQuestion from './QuestionTypes/VideoQuestion'

class Quiz extends React.Component {
    constructor(props) {
        super(props);

        this.state = {
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
        //Ajax to finish
        this.setState({ finished: true })
    }

    selectAnswer(answer) {
        let answers = this.state.answers
        answers[this.state.currentQuestion] = answer

        this.setState({
            answers
        })
    }

    render() {
        if (this.state.currentQuestion === null) {
            return <div>Loading...</div>
        }

        if (this.state.finished) {
            return <div className="main-container quiz-container"><h1 className="finished">Tillykke, du er Færdig!</h1></div>
        }

        let question = this.state.questions[this.state.currentQuestion],
            currentAnswer = this.state.answers.indexOf(this.state.currentQuestion) ? this.state.answers[this.state.currentQuestion] : null,
            answer,
            nextButton

        if (question.type == 1) {
            answer = <MultipleChoiceQuestion selectAnswer={this.selectAnswer} currentAnswer={currentAnswer} answers={question.answers} />
        }else if (question.type == 2) {
            answer = <VideoQuestion selectAnswer={this.selectAnswer} currentAnswer={currentAnswer} answers={question.answers} />
        }

        if (this.state.currentQuestion == this.state.questions.length - 1) {
            nextButton = <div className="button primary" onClick={this.handleFinish}>Afslut</div>
        }else {
            nextButton = <div className="button primary next" onClick={this.handleNextQuestion}>Næste</div>
        }

        return(
            <div>
                <div className="main-container quiz-container">
                    <div className="question">
                        <h1>{question.question}</h1>
                    </div>

                    {answer}
                </div>

                <div className="quiz-actions">
                    <div className="button primary previous" onClick={this.handlePreviousQuestion}>Forrige</div>

                    {nextButton}
                </div>
            </div>
        )
    }
}

ReactDOM.render(<Quiz/>, document.getElementById('quiz'));