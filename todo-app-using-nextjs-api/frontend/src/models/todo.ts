export type Todo = {
  id: string;
  value: string;
  done: boolean;
  created_at: Date;
  updated_at: Date;
};

export type TodoCollection = {
  data: Array<Todo>;
};

export type TodoResource = {
  data: Todo;
};
