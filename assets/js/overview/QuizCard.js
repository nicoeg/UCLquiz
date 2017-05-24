import React, { Component } from 'react'

export default class QuizCard extends Component {
	render() {
		const levels = ['Let', 'Middel', 'Svær']

		return (
			<a href={window.settings.baseUrl + (window.role == 1 ? 'teacher/edit/' : 'student/quiz/') + this.props.quiz.id} className="card">
				<div className="card__image" style={{background: "url('" + this.props.course.image + "') 50% 50%/cover"}}>
					<div className="card__labels">
						<div className="card__label">
							<p>{levels[this.props.quiz.level - 1]}</p>
						</div>
						<div className="card__label card__label--orange">
							<p>{this.props.course.name}</p>
						</div>
					</div>
				</div>
				<div className="card__title">
					<p>{this.props.quiz.title}</p>
				</div>
			</a>
		)
	}
}
