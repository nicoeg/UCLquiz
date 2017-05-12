import React, { Component } from 'react'

export default class MultipleChoiceQuestionBuilder extends Component {
	constructor(props) {
		super(props)

		this.handleQuestionChange = this.handleQuestionChange.bind(this)
	}

	handleQuestionChange(event) {
		this.props.updateQuestion(
			Object.assign(this.props.question, {
				question: event.target.value,
				answers: this.props.question.answers
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
					<input type="text" className="textfield" placeholder="Skriv spørgsmål her" value={this.props.question.question} onChange={this.handleQuestionChange} />

					<hr/>
				</div>
				{this.props.question.question}
			</div>
		)
	}
}
