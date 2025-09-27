class Category {
  id: number;
  title: string;
  subforums: Subforum[]

  constructor(id: number, title: string, subforums: Subforum[]) {
    this.id = id;
    this.title = title;
    this.subforums = subforums;
  }
}
