import React, { Component } from 'react'

export default class ClassSelect extends Component {
	constructor(props) {
		super(props);

		this.handleNameChange = this.handleNameChange.bind(this)
		this.handleLevelChange = this.handleLevelChange.bind(this)
	}

	handleNameChange(event) {
		this.props.setName(event.target.value)
	}

	handleLevelChange(level) {
		this.props.setLevel(level)
	}

	render() {
		const containerStyle = { marginTop: '40px', padding: '20px', flexDirection: 'column' }

		return (
			<div style={containerStyle} className="main-container quiz-container quiz-container--big">
				<h2 style={{paddingLeft: 0}}>Quiz navn</h2>
				<input style={{ height: '50px' }}  className="textfield" value={this.props.name} onChange={this.handleNameChange} />

				<h2 style={{paddingLeft: 0}}>Level</h2>

				<div className="button-group">
					<a className={'button' + (this.props.level === 1 ? ' button--primary' : ' button--grey')} onClick={() => this.handleLevelChange(1)}>Let</a>
					<a className={'button' + (this.props.level === 2 ? ' button--primary' : ' button--grey')} onClick={() => this.handleLevelChange(2)}>Middel</a>
					<a className={'button' + (this.props.level === 3 ? ' button--primary' : ' button--grey')} onClick={() => this.handleLevelChange(3)}>Svær</a>
				</div>
			</div>
		)
	}
}
