import React, { Component } from 'react'
import ReactDOM from 'react-dom'

import axios from 'axios'

class UserQuizResult extends Component {
	constructor() {
		super()

		this.state = {
			user_id: null
		}

		axios('/api/result/getuserresult/' + window.user_quiz_id)
			.then(response => this.setState({ user_id: response.data.user_id }))
	}

	render() {
		return (
			<h1>g</h1>
		)
	}
}

ReactDOM.render(<UserQuizResult />, document.getElementById('userquizresult'));
