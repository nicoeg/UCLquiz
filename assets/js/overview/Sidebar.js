import React, { Component } from 'react'

export default class Sidebar extends Component {
	constructor(props) {
		super(props)

		this.setFilter = this.setFilter.bind(this)
	}

	setFilter(filter) {
		this.props.setFilter(filter)
	}

	render() {
		const courses = this.props.courses.map(course => (
			<li className="sidebar__list-item" key={course.id} onClick={() => this.setFilter(course.id)}>
				<a className={'sidebar__link ' + (this.props.currentFilter == course.id ? 'sidebar__link--selected' : '')} href="#">{course.name}</a>
			</li>
		))

		return (
			<div className="sidebar">
				{ window.role == 1 ? <div style={{marginBottom: '30px'}}>
					<a style={{textDecoration: 'none'}} href={window.settings.baseUrl + 'teacher/create'} className="button button--primary">Opret quiz</a>
				</div> : ''}

				<ul className="sidebar__list">
					<li className="sidebar__list-item" onClick={() => this.setFilter(null)}>
						<a className={'sidebar__link ' + (this.props.currentFilter == null ? 'sidebar__link--selected' : '') } href="#">Nyeste quizzer</a>
					</li>

					{courses}

					<li className="sidebar__list-item" onClick={() => this.setFilter('completed')}>
						<a className={'sidebar__link ' + (this.props.currentFilter == 'completed' ? 'sidebar__link--selected' : '')} href="#">Gennemførte quizzer</a>
					</li>
				</ul>
			</div>
		)
	}
}
