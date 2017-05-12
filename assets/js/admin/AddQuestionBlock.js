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
			<div className="question-builder__add-question" onClick={() => {this.addQuestion(1)}}>Tilføj spørgsmål</div>
		)
	}
}
