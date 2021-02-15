
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
    let [onlineUsers,setOnlineUsers] = useState([])
    let [isLoading,setIsLoading] = useState(false);

    useEffect(() => {
      getOnlineUsers();
      getConversations();
    },[])

 

    let loadData = async (currentuser)=> {
      axios.get('/chat/api/messages/'+currentuser.id).then(response =>{
        setMessages(<MessageList current={currentuser} loading={isLoading} messages={response.data} />);
      })
    }

    let getOnlineUsers = async ()=> {
      axios.get('/chat/api/list_connections').then(response =>{
        setOnlineUsers([...onlineUsers,...response.data])
      })
    }
     const getConversations = () => {
    var defaultValue = 0 ;
      var userElement = document.getElementById("user_id")
      if(userElement != undefined){
        defaultValue = userElement.value;
      }
      axios.get('/chat/api/conversations/'+defaultValue).then(response => {
          setConversations([...conversations,...response.data])
          loadData(response.data[0])
      });
    }

    return (
      <div className="messenger">
        <div className="scrollable sidebar">
          {/* Conversation list */}
          <div className="conversation-list">
            <Toolbar className="fixed"
              title="Chat"
              leftItems={[
                <ToolbarButton key="cog" icon="ion-ios-cog" />
              ]}
              rightItems={[
                <ToolbarButton key="add" icon="ion-ios-add-circle-outline" />
              ]}
            />
            <Connected users={onlineUsers}  handleData={loadData} />
            <ConversationSearch />
            {
              conversations.map((conversation,index) =>
                <ConversationListItem handleData={loadData}
                  key={conversation.name + index}
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