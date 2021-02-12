import React, {useEffect} from 'react';
import shave from 'shave';

import './ConversationListItem.css';

export default function ConversationListItem(props) {

  useEffect(() => {
    shave('.conversation-snippet', 20);
  });

    const {handleData} = props;

    const { photo, name, text } = props.data;


    return (
      <div className="conversation-list-item" onClick={()=>handleData(props.data)}>
        <img className="conversation-photo" src={photo} alt="conversation" />
        <span className="isconnected"></span>
        <div className="conversation-info">
          <h1 className="conversation-title">{ name }</h1>
          <p className="conversation-snippet">{ text }</p>
        </div>
      </div>
    );
}