import React, { Component } from 'react';
import ReactDOM from 'react-dom';

export default class Example extends Component {
    render() {
        return (
            <div className="container">
                <div className="row">
                        <div className="card">
                            <div className="card-header">PhotoChoice</div>
                            <img src="http://127.0.0.1:8000/storage/photos/2019/import-072319/IMG_5011.jpg" class="img-fluid" alt="Responsive image"></img>
                            <div className="card-body">Contex Menu [choice 1] [choice 2] [choice 3]</div>
                        </div>

                </div>
            </div>
        );
    }
}

if (document.getElementById('example')) {
    ReactDOM.render(<Example />, document.getElementById('example'));
}
