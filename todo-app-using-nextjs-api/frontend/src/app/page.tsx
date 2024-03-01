"use client";

import fetcher from "@/libs/fetch";
import { TodoCollection } from "@/models/todo";
import useSWR, { useSWRConfig } from "swr";
import { Input } from "@/components/ui/input";
import { Label } from "@/components/ui/label";
import { Button } from "@/components/ui/button";
import { Checkbox } from "@/components/ui/checkbox";
import { TrashIcon } from "@/components/icon/trash";
import { ChangeEvent, useContext, useState } from "react";
import { APIClient } from "@/libs/httpclient";
import { getAPIBaseURL } from "@/libs/utils";
import { CheckedState } from "@radix-ui/react-checkbox";

type TodoItemProps = {
  id: string;
  value: string;
  checked: boolean;
  onClickDelete: (id: string) => void;
  onCheckedChange: (id: string, done: boolean) => void;
};

const TodoItem = (props: TodoItemProps) => {
  return (
    <div className="flex items-center gap-2">
      <Checkbox
        id="task-2"
        checked={props.checked}
        onCheckedChange={(checked: CheckedState) =>
          props.onCheckedChange(props.id, checked as boolean)
        }
      />
      <Label className="font-medium" htmlFor="task-2">
        {props.value}
      </Label>
      <Button
        className="ml-auto"
        size="icon"
        onClick={() => props.onClickDelete(props.id)}
      >
        <TrashIcon className="h-4 w-4" />
        <span className="sr-only">Delete task</span>
      </Button>
    </div>
  );
};

export default function Home() {
  const [task, setTask] = useState("");
  const { mutate } = useSWRConfig();
  const [client] = useState(new APIClient(getAPIBaseURL()));
  const { data, error, isLoading } = useSWR<TodoCollection, Error>(
    "/todo",
    fetcher,
  );

  if (error) return <div>failed to load</div>;
  if (isLoading) return <div>loading...</div>;

  const storeTask = async () => {
    try {
      await client.post("/todo", {
        value: task,
      });
      mutate("/todo");
    } catch (error) {
      console.error(error);
    }
  };

  const onChangeTask = (e: ChangeEvent<HTMLInputElement>) => {
    const v = e.target.value;
    setTask(v);
  };

  const onClickSubmit = async () => {
    if (task !== "") {
      await storeTask();
      setTask("");
    }
  };

  const onClickDeleteItem = async (id: string) => {
    try {
      await client.delete(`/todo/${id}`);
      mutate("/todo");
    } catch (error) {
      console.error(error);
    }
  };

  const onCheckedChangeDone = async (id: string, checked: boolean) => {
    console.log(checked);
    try {
      await client.patch(`/todo/${id}`, {
        done: checked,
        value: null,
      });
      mutate("/todo");
    } catch (error) {
      console.error(error);
    }
  };

  return (
    <div className="flex flex-col min-h-screen">
      <header className="border-b p-4">
        <h1 className="text-2xl font-bold">Todo List</h1>
      </header>
      <main className="flex-1 p-4">
        <div className="grid gap-4">
          <div className="flex gap-4">
            <Label className="flex items-center" htmlFor="new-task">
              <span className="sr-only">New task</span>
              <Input
                className="max-w-xs"
                id="new-task"
                placeholder="Enter a new task"
                type="text"
                value={task}
                onChange={onChangeTask}
              />
            </Label>
            <Button onClick={onClickSubmit}>Submit</Button>
          </div>
          <div className="grid gap-2">
            {data?.data.map((t) => {
              return (
                <TodoItem
                  key={t.id}
                  id={t.id}
                  checked={t.done}
                  value={t.value}
                  onCheckedChange={onCheckedChangeDone}
                  onClickDelete={onClickDeleteItem}
                ></TodoItem>
              );
            })}
          </div>
        </div>
      </main>
    </div>
  );
}
