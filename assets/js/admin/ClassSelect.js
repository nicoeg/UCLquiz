import React, { Component } from 'react'
import axios from 'axios'

export default class ClassSelect extends Component {
	constructor(props) {
		super(props);

		this.state = {
			courses: [],
			selectedCourse: null,
			searchQuery: ''
		}

		this.handleSearchChange = this.handleSearchChange.bind(this)
		this.setCourse = this.setCourse.bind(this)

		this.getCourses()
	}

	getCourses() {
		axios.get('/api/quiz_rest/getcourses').then(response => {
			console.log(response.data)
			this.setState({
				courses: response.data
			})
		})
	}

	handleSearchChange(event) {
		this.setState({
			searchQuery: event.target.value
		})
	}

	setCourse(courseId) {
		this.setState({
			selectedCourse: this.state.selectedCourse == courseId ? null : courseId
		})

		this.props.setCourse(courseId)
	}

	renderCourses() {
		const { courses, selectedCourse, searchQuery } = this.state

		return courses.filter(course => course.name.toLowerCase().indexOf(searchQuery) !== -1).map(course => (
			<div key={course.id} className={'course-list__item' + (course.id == selectedCourse ? ' course-list__item--active' : '')} onClick={() => this.setCourse(course.id)}>
				{course.name}
			</div>
		))
	}

	render() {
		const containerStyle = { marginTop: '40px', padding: '20px', flexDirection: 'column' }

		return (
			<div style={containerStyle} className="main-container quiz-container quiz-container--big">
				<input style={{ height: '50px' }}  className="textfield" type="search" placeholder="Søg.." onChange={this.handleSearchChange} />

				<div className="course-list">
					{this.renderCourses()}
				</div>
			</div>
		)
	}
}
