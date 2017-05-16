import React, { Component } from 'react'

export default class AddQuestionBlock extends Component {
	constructor(props) {
		super(props)

		this.addQuestion = this.addQuestion.bind(this)
	}

	addQuestion(type) {
		const question = {type: type, answers: [], question: ''}

		this.props.addQuestion(this.props.position, question)
	}

	render() {
		return (
			<div className="question-builder__add-question">
				<div className="question-builder__question-type" onClick={() => {this.addQuestion(1)}}>
					<i className="material-icons">videocam</i>
					<span>
						Video svar
					</span>
				</div>
				<div className="question-builder__question-type" onClick={() => {this.addQuestion(2)}}>
					<i className="material-icons">question_answer</i>
					<span>
						Multiple Choice
					</span>
				</div>
				<div className="question-builder__question-type" onClick={() => {this.addQuestion(2)}}>
					<i className="material-icons">videocam</i>
					<span>
						Video Svar
					</span>
				</div>
			</div>
		)
	}
}
