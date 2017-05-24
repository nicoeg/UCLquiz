import React, { Component } from 'react'

export default class StudentList extends Component {
	constructor(props) {
		super(props)
	}

	render() {
		return (
			<table className="table">
				<thead className="table__header">
					<tr className="table__item">
						<td className="table__column">Plads</td>
						<td className="table__column">Navn</td>
						<td className="table__column">Tid</td>
						<td className="table__column">Antal rigtige</td>
					</tr>
				</thead>
				<tbody className="table__body">
					<tr className="table__item">
						<td className="table__column">Plads</td>
						<td className="table__column">Navn</td>
						<td className="table__column">Tid</td>
						<td className="table__column">Antal rigtige</td>
					</tr>
					<tr className="table__item">
						<td className="table__column">Plads</td>
						<td className="table__column">Navn</td>
						<td className="table__column">Tid</td>
						<td className="table__column">Antal rigtige</td>
					</tr>
					<tr className="table__item">
						<td className="table__column">Plads</td>
						<td className="table__column">Navn</td>
						<td className="table__column">Tid</td>
						<td className="table__column">Antal rigtige</td>
					</tr>
				</tbody>
			</table>
		)
	}
}
