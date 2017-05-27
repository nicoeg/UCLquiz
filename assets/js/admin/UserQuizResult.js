import React, { Component } from 'react'
import ReactDOM from 'react-dom'
import axios from 'axios'

import QuizResults from './../QuizResults'
import MultipleChoiceQuestion from './../questionTypes/MultipleChoiceQuestion'
import VideoQuestion from './../questionTypes/VideoQuestion'

class UserQuizResult extends Component {
	constructor() {
		super()

		this.state = {
			user_id: null,
			quiz_id: null,
			quiz: null,
			userAnswers: []
		}

		axios('/api/result/getuserresult/' + window.user_quiz_id).then(response => {
			this.setState({
				user_id: response.data.user_id,
				quiz_id: response.data.quiz_id
			})

			this.getQuiz(response.data.quiz_id)
		})

		axios('/api/result/getuseranswers/' + window.user_quiz_id)
			.then(response => this.setState({ userAnswers: response.data }))
	}

	getQuiz(id) {
		axios('/api/quiz/getsingle/' + id)
			.then(response => this.setState({ quiz: response.data }))
	}

	getQuestionData(index) {
        let question = this.state.quiz.questions[index],
            userAnswer = this.state.userAnswers.find(answer => answer.question_id == question.id),
            correctAnswer = question.answers.find(answer => answer.correct == 1)

        if (question.type == 1) {
            return (
                <MultipleChoiceQuestion currentAnswer={userAnswer ? userAnswer : false}
                                        answers={question.answers}
                                        correctAnswer={correctAnswer ? correctAnswer : false}
                                        readOnly={true}/>
            )
        }else if (question.type == 2) {
            return (
                <VideoQuestion currentAnswer={userAnswer ? userAnswer : false}
                               answers={question.answers}
                               correctAnswer={correctAnswer ? correctAnswer : false}
                               readOnly={true}/>
            )
        }
    }

	render() {
		const questions = this.state.quiz ? this.state.quiz.questions.map((question, index) => (
			<div key={index} className="main-container quiz-container quiz-container--horizontal">
				<div className="question">
					<h1>{this.state.quiz.questions[index].question}</h1>
				</div>

				{this.getQuestionData(index)}
			</div>
		)) : ''

		return (
			<div>
				{questions}
			</div>
		)
	}
}

ReactDOM.render(<UserQuizResult />, document.getElementById('userquizresult'));
