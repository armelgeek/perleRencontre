import React, {useEffect} from 'react';
import shave from 'shave';

import './ConversationListItem.css';

export default function ConversationListItem(props) {

  let conversation = props.data
  let userId = props.userId
  let participants = conversation.participants.filter(p => p.uti.id != userId )
  var participant = participants[0].uti
  console.log(conversation.messages)
  let text = conversation.messages.length > 0 ? conversation.messages[conversation.messages.length -1 ].message :  'helo';
  useEffect(() => {
    shave('.conversation-snippet', 20);
  });

    const {handleData} = props;

    const { profileimage, username } = participant;

    return (
      <div className="conversation-list-item" onClick={()=>handleData(conversation)}>
        <img className="conversation-photo" src={'/assets/profiles/'+profileimage} />
        { participant.isOnline? <span className="isconnected"></span> :''}
        <div className="conversation-info">
          <h1 className="conversation-title">{ username }</h1>
          <p className="conversation-snippet">{ text }</p>
        </div>
      </div>
    );
}