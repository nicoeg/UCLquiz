import React, { Component } from 'react'

export default class StudentList extends Component {
	constructor(props) {
		super(props)
	}

	formatTime(seconds) {
        const minutes = Math.floor(seconds / 60)
        seconds = Math.round(seconds % 60)

        return `${minutes}m ${seconds}s`
    }

	render() {
		const students = this.props.students.map((student, index) => (
			<tr key={index} className="table__item">
				<td className="table__column">{index + 1}</td>
				<td className="table__column">{student.name}</td>
				<td className="table__column">{this.formatTime(student.time_seconds)}</td>
				<td className="table__column">{student.correct_answers_count}</td>
				<td className="table__column">
					<a style={{textDecoration: 'none'}} href={'/teacher/userresults/' + student.user_quiz_id} className="button button--primary button--small">Vælg</a>
				</td>
			</tr>
		))

		return (
			<table className="table">
				<thead className="table__header">
					<tr className="table__item">
						<td className="table__column">Plads</td>
						<td className="table__column">Navn</td>
						<td className="table__column">Tid</td>
						<td className="table__column">Antal rigtige</td>
						<td className="table__column">Handling</td>
					</tr>
				</thead>
				<tbody className="table__body">
					{students}
				</tbody>
			</table>
		)
	}
}
