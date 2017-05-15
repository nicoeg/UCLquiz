import React, { Component } from 'react'
import { SortableHandle } from 'react-sortable-hoc'

const blockName = 'mc-create-answer'

const DragHandle = SortableHandle(() => <span className={blockName + '__handle'}>::</span>)


export default class MultipleChoiceQuestionBuilder extends Component {
	constructor(props) {
		super(props)

		this.renderAnswer = this.renderAnswer.bind(this)
		this.addAnswer = this.addAnswer.bind(this)
		this.updateAnswer = this.updateAnswer.bind(this)
		this.toggleCorrect = this.toggleCorrect.bind(this)
		this.inputChange = this.inputChange.bind(this)
		this.deleteAnswer = this.deleteAnswer.bind(this)
	}

	renderAnswer(answer, index) {
		return (
			<div key={answer.id} className={blockName}>
				<span className="number">{index+1}.</span>

				<input className={blockName + '__input textfield'} type="text" value={answer.value} onChange={event => this.inputChange(answer, event.target.value)} />

				<span className={'button ' + (answer.correct ? 'button--success' : 'button--grey')} onClick={() => this.toggleCorrect(answer)}>Korrekt svar</span>

				<span className={blockName + '__delete-button button button--grey'} onClick={() => this.deleteAnswer(index)}><i className="material-icons">delete</i></span>
			</div>
		)
	}

	inputChange(answer, value) {
		answer.value = value

		this.updateAnswer(answer)
	}

	toggleCorrect(answer) {
		answer.correct = ! answer.correct

		this.updateAnswer(answer)
	}

	updateAnswer(answer) {
		let answers = this.props.answers
		const index = answers.find(a => a.id == answer.id)

		answers[index] = answer

		this.props.updateAnswers(answers)
	}

	addAnswer() {
		let answers = this.props.answers
		const latest = answers.sort((a, b) => b.id - a.id)[0]
		answers.push({ id: latest ? latest.id + 1 : 1, value: '' })

		this.props.updateAnswers(answers)
	}

	deleteAnswer(index) {
		let answers = this.props.answers

		answers.splice(index, 1)

		this.props.updateAnswers(answers)
	}

	render() {
		return (
			<div>
				{this.props.answers.map((answer, index) => this.renderAnswer(answer, index))}

				<div style={{margin: '20px 0'}}>
					<span className="button button--primary" onClick={this.addAnswer}>Tilføj svar</span>
				</div>
			</div>
		)
	}
}
