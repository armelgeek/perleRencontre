
import React,{useState,useEffect} from 'react';
import MessageList from '../MessageList';
import ConversationSearch from '../ConversationSearch';
import Connected from '../Connected';
import ConversationListItem from '../ConversationListItem';
import Toolbar from '../Toolbar';
import ToolbarButton from '../ToolbarButton';
import axios from 'axios';
import './Messenger.css';

export default function Messenger(props) {
    let [messages,setMessages] = useState();
    const [conversations, setConversations] = useState([]);

    useEffect(() => {
      getConversations()
    },[])

  const getConversations = () => {
      let convers = [{
          id: 1,
          author: 'apple',
          message: 'Hello world! This is a long message that will hopefully get wrapped by our message bubble component! We will see how well it works.',
          timestamp: new Date().getTime()
        },]
      axios.get('https://randomuser.me/api/?results=20').then(response => {
          let newConversations = response.data.results.map((result,i) => {
            let userData = {
              photo: result.picture.large,
              name: `${result.name.first} ${result.name.last}`,
              text: 'Hello world! This is a long message that needs to be truncated.'
            }
            if(  i === 0){
              setMessages(<MessageList current={userData} messages={convers} />);
            }
            return userData;
          });
          setConversations([...conversations, ...newConversations])
      });
    }

    let loadData = (currentuser)=> {

      let profile_data = [
        {
          id: 1,
          author: 'apple',
          message: 'Hello world! This is a long message that will hopefully get wrapped by our message bubble component! We will see how well it works.',
          timestamp: new Date().getTime()
        },
        {
          id: 2,
          author: 'orange',
          message: 'It looks like it wraps exactly as it is supposed to. Lets see what a reply looks like!',
          timestamp: new Date().getTime()
        },
        {
          id: 3,
          author: 'orange',
          message: 'Hello world! This is a long message that will hopefully get wrapped by our message bubble component! We will see how well it works.',
          timestamp: new Date().getTime()
        },
        {
          id: 4,
          author: 'apple',
          message: 'It looks like it wraps exactly as it is supposed to. Lets see what a reply looks like!',
          timestamp: new Date().getTime()
        },
        {
          id: 5,
          author: 'apple',
          message: 'Hello world! This is a long message that will hopefully get wrapped by our message bubble component! We will see how well it works.',
          timestamp: new Date().getTime()
        },
        {
          id: 6,
          author: 'apple',
          message: 'It looks like it wraps exactly as it is supposed to. Lets see what a reply looks like!',
          timestamp: new Date().getTime()
        },
        {
          id: 7,
          author: 'orange',
          message: 'Hello world! This is a long message that will hopefully get wrapped by our message bubble component! We will see how well it works.',
          timestamp: new Date().getTime()
        },
        {
          id: 8,
          author: 'orange',
          message: 'It looks like it wraps exactly as it is supposed to. Lets see what a reply looks like!',
          timestamp: new Date().getTime()
        },
        {
          id: 9,
          author: 'apple',
          message: 'Hello world! This is a long message that will hopefully get wrapped by our message bubble component! We will see how well it works.',
          timestamp: new Date().getTime()
        },
        {
          id: 10,
          author: 'orange',
          message: 'It looks like it wraps exactly as it is supposed to. Lets see what a reply looks like!',
          timestamp: new Date().getTime()
        },
      ];
      setMessages(<MessageList current={currentuser} messages={profile_data} />);
      console.log(profile_data);
    }

    return (
      <div className="messenger">
        <div className="scrollable sidebar">
          {/* Conversation list */}
          <div className="conversation-list">
            <Toolbar className="fixed"
              title="Perle Chat"
              leftItems={[
                <ToolbarButton key="cog" icon="ion-ios-cog" />
              ]}
              rightItems={[
                <ToolbarButton key="add" icon="ion-ios-add-circle-outline" />
              ]}
            />
            <Connected users={conversations}  handleData={loadData} />
            <ConversationSearch />
            {
              conversations.map(conversation =>
                <ConversationListItem handleData={loadData}
                  key={conversation.name}
                  data={conversation}
                />
              )
            }
          </div>
        </div>
        {/* Message */}
        <div className="scrollable content">
          {messages}
        </div>
      </div>
    );
}