import React, {useEffect, useState} from 'react';
import Compose from '../Compose';
import Toolbar from '../Toolbar';
import ToolbarButton from '../ToolbarButton';
import Message from '../Message';
import moment from 'moment';
import Picker from 'emoji-picker-react';

import './MessageList.css';

const MY_USER_ID = 'apple';

export default function MessageList(props) {
  // const [messages, setMessages] = useState([])
  const {messages,current} = props;
  const [chosenEmoji, setChosenEmoji] = useState(null);
  const [emojiState, setEmojiState] = useState('none');
 
  useEffect(() => {
  },[])

  const onEmojiClick = (event, emojiObject) => {
    
  };

  const toggleEmoji = () =>{
    if(emojiState === 'none'){
      setEmojiState('block');
    }
    else{
      setEmojiState('none');
    }
  }

  const renderMessages = () => {
    let i = 0;
    let messageCount = messages.length;
    let tempMessages = [];

    while (i < messageCount) {
      let previous = messages[i - 1];
      let current = messages[i];
      let next = messages[i + 1];
      let isMine = current.author === MY_USER_ID;
      let currentMoment = moment(current.timestamp);
      let prevBySameAuthor = false;
      let nextBySameAuthor = false;
      let startsSequence = true;
      let endsSequence = true;
      let showTimestamp = true;

      if (previous) {
        let previousMoment = moment(previous.timestamp);
        let previousDuration = moment.duration(currentMoment.diff(previousMoment));
        prevBySameAuthor = previous.author === current.author;
        
        if (prevBySameAuthor && previousDuration.as('hours') < 1) {
          startsSequence = false;
        }

        if (previousDuration.as('hours') < 1) {
          showTimestamp = false;
        }
      }

      if (next) {
        let nextMoment = moment(next.timestamp);
        let nextDuration = moment.duration(nextMoment.diff(currentMoment));
        nextBySameAuthor = next.author === current.author;

        if (nextBySameAuthor && nextDuration.as('hours') < 1) {
          endsSequence = false;
        }
      }

      tempMessages.push(
        <Message
          key={i}
          isMine={isMine}
          startsSequence={startsSequence}
          endsSequence={endsSequence}
          showTimestamp={showTimestamp}
          data={current}
        />
      );

      // Proceed to the next message.
      i += 1;
    }
    console.log(messages);
    return tempMessages;
  }

    return(
      <div className="message-list">
        <Toolbar
         leftItems ={[
          <img className="conversation-photo"  key="profile-image" alt="conversation" src={current.photo} />,
          <span className="connected-state" key="profile-state" ></span>,
          <div key="profile">
            <div className="profile-name">{current.name}</div>
            <div className="profile-state">{current.name}</div>
          </div>
         ]}
          rightItems={[
            <ToolbarButton key="info" icon="ion-ios-information-circle-outline" />,
            <ToolbarButton key="video" icon="ion-ios-videocam" />,
            <ToolbarButton key="phone" icon="ion-ios-call" />
          ]}
        />

        <div className="message-list-container">{renderMessages()}</div>
        
        <Compose leftItems={[
          <ToolbarButton key="photo" icon="ion-ios-camera" />,
          <ToolbarButton key="image" icon="ion-ios-image" />,
          <ToolbarButton key="attache" icon="ion-ios-attach" />,
          <ToolbarButton key="audio" icon="ion-ios-mic" />,
          <button key="emoji" style={{ border:'none'}} onClick={()=>toggleEmoji()}><ToolbarButton style={{ color:'#aea'}}icon="ion-ios-happy" /></button>,
        ]} 
        
        rightItems={[
          <ToolbarButton key="thumbs"  icon="ion-ios-thumbs-up" />,
          <ToolbarButton key="photo" icon="ion-md-send" />,
        ]}/>
        <div style={{position: 'fixed',marginBottom:'50px' }}><Picker onEmojiClick={onEmojiClick} pickerStyle={{display:`${emojiState}`}} /></div>
      </div>
    );
}