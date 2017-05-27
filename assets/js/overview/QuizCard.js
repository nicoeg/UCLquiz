import React, { Component } from 'react'

export default class QuizCard extends Component {
	render() {
		const levels = ['Let', 'Middel', 'Svær']

		return (
			<div className="card">
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
					<div className="card__title-text">{this.props.quiz.title}</div>

					{window.role == 1 ?
						<div>
							<a href={window.settings.baseUrl + 'teacher/edit/' + this.props.quiz.id} className="button button--primary button--small">Rediger quiz</a>

							<a href={'/teacher/results/' + this.props.quiz.id} style={{marginLeft: '5px'}} className="button button--primary button--small">Resultater</a>
						</div>
					: 
						<div>
							<a href={window.settings.baseUrl + 'student/quiz/' + this.props.quiz.id} className="button button--primary button--small">Tag quiz</a>
						</div>
					}
				</div>
			</div>
		)
	}
}
