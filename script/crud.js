const yargs = require('yargs');
const axios = require('axios').default;
const Table = require('cli-table');

let argv = yargs.argv
let type = argv.type;


switch(type){
  case "list":
    axios.get('http://demo-web/tasks')
      .then(res=>{

        if(res.data.data.length > 0){

          //Render only when there is a data
          var table = new Table({ head: ["#", "Task ID", "Title", "Description", "Status"] });
          (res.data.data).forEach(function(e, i) {
            table.push([i+1, e['id'], e['title'], e['description'], e['status']]);
          });

          console.log(table.toString());
        }else{
          console.log("There is no available task! Please insert new using --type=add");
        }

      }).catch(function (error){
        console.log("There an error reaching the API");
    });

  break;
  case "add":
      var title = argv.title;
      var desc = argv.desc;

      if(title){
        var data = {
          'title': title,
          'description': desc,
          };

        axios.post('http://demo-web/api/tasks', data)
          .then(res=>{

            if(res.data.status === true){
              //any furhter action
            }

            console.log(res.data.messages);

          }).catch(function (error){
            console.log("There an error reaching the API");
          });

        break;
      }

      console.log('Please makesure all agrument is there! (--title , --desc (optional))');
    break;
    case "show":
      var id = argv.id;
      if(id){

        var table = new Table();
        axios.get('http://demo-web/api/tasks/'+id)
          .then(res=>{

            let data = res.data;
            let create_time = new Date(data.created_at);
            let update_time = new Date(data.updated_at);

            table.push(
                    {'Task ID': data.id},
                    {'Title': data.title},
                    {'Description': data.description},
                    {'Status': data.currentstatus},
                    {'Created at': create_time.toLocaleString()},
                    {'Last updated at': update_time.toLocaleString()},
                    );
            console.log(table.toString());

          }).catch(function (error){
            console.log("There an error reaching the API");
          });

        break;
      }

      console.log('Please makesure all agrument is there! (--title , --desc (optional))');
      break;

    case "edit":

        var id = argv.id;
        var title = argv.title;
        var desc = argv.desc;
        var status = argv.status;

        if(id){

          var data = null;

          data = (title) ? {...data, 'title': title} : data;
          data = (desc) ? {...data, 'description': desc} : data;
          data = (status) ? {...data, 'status': status} : data;

          if(data){
            axios.patch('http://demo-web/api/tasks/'+id, data)
            .then(res=>{

              if(res.data.status === true){

              }
              console.log(res.data.messages);

            }).catch(function (error){
              console.log("There an error reaching the API");
            });

            break;
          }

          console.log('Please specify at-least one argruments to be update! (--title(optional) , --desc(optional), --status(optional))');
          
          break;
        }        

        console.log('Please add id argruments to be update! (--id');
      break;
    case "delete":
      var id = argv.id;

      if(id){

        axios.delete('http://demo-web/api/tasks/'+id)
          .then(res=>{

            if(res.data.status === true){

            }

            console.log(res.data.messages);

          }).catch(function (error){
            console.log("There an error reaching the API");
          });

        break;
      }

      console.log('Please makesure required agrument is there! (--id)');
      break;

  default:
    console.log("Please specific an argruments list, add, show, update, delete");
}
