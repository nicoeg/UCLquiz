import React, { Component } from 'react'

export default class ProgressBar extends Component {
	constructor(props) {
		super(props)
	}

	progress() {
		return this.props.currentQuestion / this.props.quizLength * 100
	}

	render() {
		return (
			<div style={{minHeight: 0, margin: '-50px auto 50px auto'}} className="quiz-container">
				<div style={{ width: this.progress() + '%'}} className="progressbar" data-progress={this.props.currentQuestion + '/' + this.props.quizLength}></div>
			</div>
		)
	}
}
