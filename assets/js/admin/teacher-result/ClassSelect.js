import React, { Component } from 'react'
import axios from 'axios'

export default class ClassSelect extends Component {
	constructor(props) {
		super(props)

		this.state = {
			classes: []
		}

		axios.get('/api/result/getclasslist/' + window.quiz_id)
			.then(response => this.setState({ classes: response.data }))
	}

	render() {
		const classes = this.state.classes.map(classRecord => (
			<tr key={classRecord.id} className="table__item">
				<td className="table__column">{classRecord.name}</td>
				<td className="table__column">
					<span className="button button--primary button--small" onClick={() => this.props.onClassSelected(classRecord.id)}>Vælg</span>
				</td>
			</tr>
		))

		return (
			<table className="table">
				<thead className="table__header">
					<tr className="table__item">
						<td className="table__column">Klasse</td>
						<td className="table__column">Handling</td>
					</tr>
				</thead>
				<tbody className="table__body">
					{classes}
				</tbody>
			</table>
		)
	}
}
