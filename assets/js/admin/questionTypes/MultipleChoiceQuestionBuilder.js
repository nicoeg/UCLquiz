import React, { Component } from 'react'

export default class MultipleChoiceQuestionBuilder extends Component {
	constructor(props) {
		super(props)

		this.state = {
			question: props.question.question,
			answers: props.question.answers
		}

		this.handleQuestionChange = this.handleQuestionChange.bind(this)
		this.updateQuestion = this.updateQuestion.bind(this)
	}

	handleQuestionChange(event) {
		this.setState({
			question: event.target.value
		}, this.updateQuestion)
	}

	updateQuestion() {
		this.props.updateQuestion(
			Object.assign(this.props.question, {
				question: this.state.question,
				answers: this.state.answers
			})
		)
	}

	render() {
		const blockName = 'multiple-choice-builder'

		return (
			<div className={blockName}>
				<div className={blockName + '__header'}>
					<button className="button button--small button--primary">Multiple choice</button>
				</div>
				<div className={blockName + '__body'}>
					<input type="text" className="textfield" placeholder="Skriv spørgsmål her" value={this.state.question} onChange={this.handleQuestionChange} />

					<hr/>
				</div>
				{this.props.question.question}
			</div>
		)
	}
}
