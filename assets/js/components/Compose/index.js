import React,{useState} from 'react';
import './Compose.css';


export default function Compose(props) {

    return (
      <div className="compose">
      {
          props.leftItems
        }
        <input
          type="text"
          className="compose-input"
          placeholder="Type a message, @name"
        />
        {
          props.rightItems
        }
      </div>
    );
}